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
            ->whereNotNull('photo_url')
            ->orderByDesc('arrival_date')
            ->limit(6)
            ->get();

        $classes = Animal::with('species')
            ->where('status', 'на продажу')
            ->get()
            ->pluck('species.class')
            ->unique()
            ->filter();

        return view('public.home', compact('newArrivals', 'classes'));
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