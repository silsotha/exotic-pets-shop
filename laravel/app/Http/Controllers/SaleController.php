<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Animal;
use App\Models\Client;
use App\Models\Employee;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    // список продаж
    public function index(Request $request)
    {
        $query = Sale::with(['animal.species', 'client', 'employee']);

        if ($request->filled('date_from')) {
            $query->where('sale_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('sale_date', '<=', $request->date_to);
        }
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $sales = $query->orderBy('sale_date', 'desc')->paginate(15);

        // итого за выбранный период
        $total = $query->sum('total_price');

        return view('sales.index', compact('sales', 'total'));
    }

    // форма оформления продажи
    public function create()
    {
        $animals = Animal::with('species')
            ->where('status', 'на продажу')
            ->orderBy('arrival_date')
            ->get();
        $clients = Client::orderBy('full_name')->get();
        $employees = Employee::where('role', 'продавец')->orderBy('full_name')->get();

        return view('sales.create', compact('animals', 'clients', 'employees'));
    }

    // сохранение продажи
    public function store(Request $request)
    {
        $validated = $request->validate([
            'animal_id' => 'required|exists:animals,animal_id',
            'client_id' => 'required|exists:clients,client_id',
            'employee_id' => 'required|exists:employees,employee_id',
            'sale_date' => 'required|date',
            'total_price' => 'required|numeric|min:0',
            'payment_method' => 'required|in:наличные,карта,перевод',
            'contract_number' => 'nullable|string|max:30',
        ]);

        // проверяем что животное ещё доступно
        $animal = Animal::find($validated['animal_id']);
        if ($animal->status !== 'на продажу') {
            return back()->with('error', 'Это животное уже недоступно для продажи.')->withInput();
        }

        // создаём продажу
        Sale::create($validated);

        // меняем статус животного
        $animal->update(['status' => 'продано']);

        return redirect()->route('sales.index')
            ->with('success', 'Продажа успешно оформлена!');
    }

    // просмотр продажи
    public function show(Sale $sale)
    {
        $sale->load(['animal.species', 'client', 'employee']);
        return view('sales.show', compact('sale'));
    }

    // удаление (отмена продажи — только для администратора)
    public function destroy(Sale $sale)
    {
        // возвращаем животное в статус "на продажу"
        $sale->animal->update(['status' => 'на продажу']);
        $sale->delete();

        return redirect()->route('sales.index')
            ->with('success', 'Продажа отменена, животное возвращено в каталог.');
    }

    // заглушки для неиспользуемых методов resource
    public function edit(Sale $sale)
    {
        abort(404);
    }
    public function update(Request $request, Sale $sale)
    {
        abort(404);
    }
}