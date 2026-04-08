<?php

namespace App\Http\Controllers;

use App\Models\Species;
use Illuminate\Http\Request;

class SpeciesController extends Controller
{
    public function index()
    {
        $species = Species::withCount('animals')->orderBy('name')->paginate(15);
        return view('species.index', compact('species'));
    }

    public function create()
    {
        return view('species.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'class' => 'required|string|max:50',
            'habitat' => 'nullable|string|max:200',
            'temp_min' => 'nullable|numeric',
            'temp_max' => 'nullable|numeric',
            'humidity_min' => 'nullable|numeric',
            'humidity_max' => 'nullable|numeric',
            'quarantine_days' => 'required|integer|min:1',
        ]);

        Species::create($request->all());

        return redirect()->route('species.index')
            ->with('success', 'Вид добавлен.');
    }

    public function edit(Species $species)
    {
        return view('species.edit', compact('species'));
    }

    public function update(Request $request, Species $species)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'class' => 'required|string|max:50',
            'habitat' => 'nullable|string|max:200',
            'temp_min' => 'nullable|numeric',
            'temp_max' => 'nullable|numeric',
            'humidity_min' => 'nullable|numeric',
            'humidity_max' => 'nullable|numeric',
            'quarantine_days' => 'required|integer|min:1',
        ]);

        $species->update($request->all());

        return redirect()->route('species.index')
            ->with('success', 'Вид обновлён.');
    }

    public function destroy(Species $species)
    {
        if ($species->animals()->count() > 0) {
            return back()->with('error', 'Нельзя удалить вид — есть привязанные животные.');
        }

        $species->delete();
        return redirect()->route('species.index')
            ->with('success', 'Вид удалён.');
    }

    public function show(Species $species)
    {
        abort(404);
    }
}