<?php

namespace App\Http\Controllers;

use App\Models\VetRecord;
use App\Models\Animal;
use App\Models\Employee;
use Illuminate\Http\Request;

class VetController extends Controller
{
    // список всех ветзаписей
    public function index(Request $request)
    {
        $query = VetRecord::with(['animal.species', 'vet']);

        if ($request->filled('record_type')) {
            $query->where('record_type', $request->record_type);
        }

        if ($request->filled('result')) {
            $query->where('result', $request->result);
        }

        $records = $query->orderBy('record_date', 'desc')->paginate(15);

        return view('vet.index', compact('records'));
    }

    // форма добавления записи
    public function create(Request $request)
    {
        // можно передать animal_id через URL: /vet/create?animal_id=5
        $animals = Animal::with('species')
            ->whereIn('status', ['карантин', 'на продажу'])
            ->orderBy('arrival_date', 'desc')
            ->get();

        $vets = Employee::where('role', 'ветврач')->orderBy('full_name')->get();

        $selectedAnimal = $request->filled('animal_id') ? $request->animal_id : null;

        return view('vet.create', compact('animals', 'vets', 'selectedAnimal'));
    }

    // сохранение записи
    public function store(Request $request)
    {
        $validated = $request->validate([
            'animal_id'   => 'required|exists:animals,animal_id',
            'vet_id'      => 'required|exists:employees,employee_id',
            'record_date' => 'required|date',
            'record_type' => 'required|in:осмотр,прививка,лечение',
            'diagnosis'   => 'nullable|string',
            'treatment'   => 'nullable|string',
            'result'      => 'required|in:здоров,на лечении,карантин',
        ]);

        VetRecord::create($validated);

        // если результат "здоров" и животное на карантине — предлагаем перевести
        $animal = Animal::find($validated['animal_id']);
        if ($validated['result'] === 'здоров' && $animal->status === 'карантин') {
            return redirect()->route('vet.index')
                ->with('success', 'Запись добавлена. Животное здорово — можно перевести на продажу.')
                ->with('approve_animal_id', $animal->animal_id);
        }

        return redirect()->route('vet.index')
            ->with('success', 'Ветеринарная запись добавлена.');
    }

    // просмотр одной записи
    public function show(VetRecord $vet)
    {
        $vet->load(['animal.species', 'vet']);
        return view('vet.show', ['vetRecord' => $vet]);
    }

    // форма редактирования
    public function edit(VetRecord $vet)
    {
        $animals = Animal::with('species')->orderBy('arrival_date', 'desc')->get();
        $vets    = Employee::where('role', 'ветврач')->orderBy('full_name')->get();
        return view('vet.edit', ['vetRecord' => $vet, 'animals' => $animals, 'vets' => $vets]);
    }

    // обновление
    public function update(Request $request, VetRecord $vet)
    {
        $validated = $request->validate([
            'animal_id'   => 'required|exists:animals,animal_id',
            'vet_id'      => 'required|exists:employees,employee_id',
            'record_date' => 'required|date',
            'record_type' => 'required|in:осмотр,прививка,лечение',
            'diagnosis'   => 'nullable|string',
            'treatment'   => 'nullable|string',
            'result'      => 'required|in:здоров,на лечении,карантин',
        ]);

        $vet->update($validated);

        return redirect()->route('vet.index')
            ->with('success', 'Запись обновлена.');
    }

    // удаление
    public function destroy(VetRecord $vet)
    {
        $vet->delete();
        return redirect()->route('vet.index')
            ->with('success', 'Запись удалена.');
    }
}