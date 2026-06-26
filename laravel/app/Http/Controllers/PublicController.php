<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Feed;
use App\Models\Species;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $newArrivals = Animal::with('species')
            ->where('status', 'на продажу')
            ->orderByDesc('arrival_date')
            ->limit(4)
            ->get();

        $featuredFeeds = Feed::query()
            ->with('species:species_id,name')
            ->whereHas('species')
            ->orderByRaw("CASE WHEN LOWER(feed_type) LIKE '%жив%' THEN 1 WHEN LOWER(feed_type) LIKE '%заморож%' THEN 2 ELSE 3 END")
            ->orderBy('name')
            ->limit(3)
            ->get();

        $availableCount = Animal::where('status', 'на продажу')->count();
        $speciesCount = Species::count();
        $suppliersCount = \App\Models\Supplier::count();

        $categoryCounts = Animal::with('species')
            ->where('status', 'на продажу')
            ->get()
            ->groupBy('species.class')
            ->map->count()
            ->filter();

        return view('public.home', compact(
            'newArrivals',
            'featuredFeeds',
            'availableCount',
            'speciesCount',
            'suppliersCount',
            'categoryCounts'
        ));
    }

    public function about()
    {
        return view('public.about');
    }

    public function howToChoose()
    {
        return view('public.how-to-choose');
    }

    public function feeds(Request $request)
    {
        $query = Feed::query()
            ->with('species:species_id,name')
            ->whereHas('species');

        if ($request->filled('type')) {
            $query->where('feed_type', $request->string('type'));
        }

        if ($request->filled('species')) {
            $query->whereHas('species', function ($speciesQuery) use ($request) {
                $speciesQuery->where('species.species_id', $request->integer('species'));
            });
        }

        $feeds = $query->orderBy('name')->paginate(12)->withQueryString();

        $feedTypes = Feed::query()
            ->whereNotNull('feed_type')
            ->where('feed_type', '!=', '')
            ->whereHas('species')
            ->orderBy('feed_type')
            ->distinct()
            ->pluck('feed_type');

        $species = Species::query()
            ->whereHas('feeds')
            ->orderBy('name')
            ->get(['species_id', 'name']);

        return view('public.feeds', compact('feeds', 'feedTypes', 'species'));
    }

    public function catalog(Request $request)
    {
        $query = Animal::with('species')->where('status', 'на продажу');

        if ($request->filled('class')) {
            $query->whereHas('species', fn($q) => $q->where('class', $request->class));
        }

        if ($request->filled('care_level')) {
            $query->whereHas('species', function ($q) use ($request) {
                $q->where('care_level', $request->care_level);
            });
        }

        $careLevels = [
            'beginner' => 'Подходит новичкам',
            'intermediate' => 'Средняя сложность',
            'advanced' => 'Для опытных владельцев',
        ];

        if ($request->filled('sort')) {
            match ($request->sort) {
                'price_asc' => $query->orderBy('sale_price'),
                'price_desc' => $query->orderByDesc('sale_price'),
                default => $query->orderByDesc('arrival_date'),
            };
        } else {
            $query->orderByDesc('arrival_date');
        }

        $animals = $query->paginate(12);

        $classes = Species::whereHas(
            'animals',
            fn($q) => $q->where('status', 'на продажу')
        )->pluck('class')->unique();

        return view('public.catalog', compact('animals', 'classes', 'careLevels'));
    }

    public function show(Animal $animal)
    {
        if ($animal->status !== 'на продажу') {
            abort(404);
        }

        $animal->load('species');

        $suitableFeeds = $animal->species
            ->feeds()
            ->orderByRaw("
        CASE
            WHEN LOWER(feed_type) LIKE '%жив%' THEN 1
            WHEN LOWER(feed_type) LIKE '%заморож%' THEN 2
            ELSE 3
        END
    ")
            ->orderBy('name')
            ->get();

        $displayFeeds = $suitableFeeds
            ->groupBy(function (Feed $feed) {
                $normalizedName = mb_strtolower(trim($feed->name));

                if (
                    str_contains($normalizedName, 'мыш') ||
                    str_contains($normalizedName, 'крыс')
                ) {
                    return 'rodent:' . $normalizedName;
                }

                return 'feed:' . $feed->feed_id;
            })
            ->map(function ($group) {
                return [
                    'feed' => $group->first(),
                    'variants' => $group
                        ->sortBy('prey_weight_min')
                        ->values(),
                ];
            })
            ->take(3)
            ->values();

        $similar = Animal::with('species')
            ->where('status', 'на продажу')
            ->where('species_id', $animal->species_id)
            ->where('animal_id', '!=', $animal->animal_id)
            ->limit(3)
            ->get();

        return view('public.show', compact(
            'animal',
            'similar',
            'displayFeeds'
        ));
    }
}
