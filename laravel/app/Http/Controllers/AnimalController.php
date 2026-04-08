<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Species;
use App\Models\Supplier;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    // список всех животных
    public function index(Request $request)
    {
        $query = Animal::with(['species', 'supplier']);

        // фильтр по статусу
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // фильтр по виду
        if ($request->filled('species_id')) {
            $query->where('species_id', $request->species_id);
        }

        $animals  = $query->orderBy('arrival_date', 'desc')->paginate(15);
        $species  = Species::orderBy('name')->get();

        return view('animals.index', compact('animals', 'species'));
    }

    // форма создания
    public function create()
    {
        $species   = Species::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        return view('animals.create', compact('species', 'suppliers'));
    }

    // сохранение нового животного
    public function store(Request $request)
    {
        $validated = $request->validate([
            'species_id'       => 'required|exists:species,species_id',
            'supplier_id'      => 'required|exists:suppliers,supplier_id',
            'nickname'         => 'nullable|string|max:50',
            'sex'              => 'required|in:самец,самка,не определён',
            'birth_date'       => 'nullable|date|before:today',
            'arrival_date'     => 'required|date',
            'purchase_price'   => 'required|numeric|min:0',
            'sale_price'       => 'required|numeric|min:0',
            'cites_certificate'=> 'nullable|string|max:50',
        ]);

        // новое животное всегда начинает с карантина
        $validated['status'] = 'карантин';

        Animal::create($validated);

        return redirect()->route('animals.index')
            ->with('success', 'Животное успешно добавлено и отправлено на карантин.');
    }

    // карточка животного
    public function show(Animal $animal)
    {
        $animal->load(['species', 'supplier', 'vetRecords.vet', 'feedingLog.feed', 'sale.client']);
        return view('animals.show', compact('animal'));
    }

    // форма редактирования
    public function edit(Animal $animal)
    {
        $species   = Species::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        return view('animals.edit', compact('animal', 'species', 'suppliers'));
    }

    // обновление
    public function update(Request $request, Animal $animal)
    {
        $validated = $request->validate([
            'species_id'       => 'required|exists:species,species_id',
            'supplier_id'      => 'required|exists:suppliers,supplier_id',
            'nickname'         => 'nullable|string|max:50',
            'sex'              => 'required|in:самец,самка,не определён',
            'birth_date'       => 'nullable|date|before:today',
            'arrival_date'     => 'required|date',
            'status'           => 'required|in:карантин,на продажу,продано,списано',
            'purchase_price'   => 'required|numeric|min:0',
            'sale_price'       => 'required|numeric|min:0',
            'cites_certificate'=> 'nullable|string|max:50',
        ]);

        $animal->update($validated);

        return redirect()->route('animals.show', $animal)
            ->with('success', 'Данные животного обновлены.');
    }

    // удаление
    public function destroy(Animal $animal)
    {
        // нельзя удалить проданное животное
        if ($animal->status === 'продано') {
            return back()->with('error', 'Нельзя удалить проданное животное.');
        }

        $animal->delete();

        return redirect()->route('animals.index')
            ->with('success', 'Животное удалено.');
    }

    // быстрая смена статуса (карантин → на продажу)
    public function approve(Animal $animal)
    {
        if ($animal->status !== 'карантин') {
            return back()->with('error', 'Животное не находится на карантине.');
        }

        $animal->update(['status' => 'на продажу']);

        return back()->with('success', 'Животное переведено в статус "На продажу".');
    }
}