<?php

namespace App\Http\Controllers;

use App\Models\Species;
use App\Models\Feed;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'description' => 'nullable|string|max:2000',
            'care_level' => 'nullable|in:beginner,intermediate,advanced',
            'temp_min' => 'nullable|numeric',
            'temp_max' => 'nullable|numeric',
            'humidity_min' => 'nullable|numeric',
            'humidity_max' => 'nullable|numeric',
            'quarantine_days' => 'required|integer|min:1',
            'feeding_group' => [
                'required',
                'string',
                'max:50',
                Rule::in(
                    collect(config('exotic.animal_groups', []))
                        ->flatten()
                        ->all()
                ),
            ],
        ]);

        $species = Species::create($request->all());

        $feedIds = Feed::query()
            ->whereJsonContains('animal_classes', $species->class)
            ->pluck('feed_id');

        $species->feeds()->syncWithoutDetaching($feedIds);


        return redirect()->route('admin.species.index')
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
            'description' => 'nullable|string|max:2000',
            'care_level' => 'nullable|in:beginner,intermediate,advanced',
            'temp_min' => 'nullable|numeric',
            'temp_max' => 'nullable|numeric',
            'humidity_min' => 'nullable|numeric',
            'humidity_max' => 'nullable|numeric',
            'quarantine_days' => 'required|integer|min:1',
            'feeding_group' => [
                'required',
                'string',
                'max:50',
                Rule::in(
                    collect(config('exotic.animal_groups', []))
                        ->flatten()
                        ->all()
                ),
            ],
        ]);

        $species->update($request->all());

        return redirect()->route('admin.species.index')
            ->with('success', 'Вид обновлён.');
    }

    public function destroy(Species $species)
    {
        if ($species->animals()->count() > 0) {
            return back()->with('error', 'Нельзя удалить вид — есть привязанные животные.');
        }

        $species->delete();
        return redirect()->route('admin.species.index')
            ->with('success', 'Вид удалён.');
    }

    public function show(Species $species)
    {
        abort(404);
    }
}
