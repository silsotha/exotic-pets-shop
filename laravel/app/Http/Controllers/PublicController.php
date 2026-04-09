<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Species;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    // главная страница
    public function home()
    {
        $newArrivals = Animal::with('species')
            ->where('status', 'на продажу')
            ->orderByDesc('arrival_date')
            ->limit(4)
            ->get();

        // счётчики для hero
        $availableCount  = Animal::where('status', 'на продажу')->count();
        $speciesCount    = \App\Models\Species::count();
        $suppliersCount  = \App\Models\Supplier::count();

        // категории с количеством
        $categoryCounts = Animal::with('species')
            ->where('status', 'на продажу')
            ->get()
            ->groupBy('species.class')
            ->map->count()
            ->filter();

        return view('public.home', compact(
            'newArrivals', 'availableCount',
            'speciesCount', 'suppliersCount', 'categoryCounts'
        ));
    }
    
    public function about()
    {
        return view('public.about');
    }

    // каталог
    public function catalog(Request $request)
    {
        $query = Animal::with('species')
            ->where('status', 'на продажу');

        if ($request->filled('class')) {
            $query->whereHas(
                'species',
                fn($q) =>
                $q->where('class', $request->class)
            );
        }

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
            fn($q) =>
            $q->where('status', 'на продажу')
        )->pluck('class')->unique();

        return view('public.catalog', compact('animals', 'classes'));
    }

    // карточка животного
    public function show(Animal $animal)
    {
        if ($animal->status !== 'на продажу') {
            abort(404);
        }

        $animal->load('species');

        // похожие животные того же вида
        $similar = Animal::with('species')
            ->where('status', 'на продажу')
            ->where('species_id', $animal->species_id)
            ->where('animal_id', '!=', $animal->animal_id)
            ->limit(3)
            ->get();

        return view('public.show', compact('animal', 'similar'));
    }
}