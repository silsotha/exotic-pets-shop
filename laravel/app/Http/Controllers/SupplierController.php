<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::withCount('animals')->orderBy('name')->paginate(15);
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'contact_person' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'license_number' => 'nullable|string|max:50',
        ]);

        Supplier::create($request->all());

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Поставщик добавлен.');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'contact_person' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'license_number' => 'nullable|string|max:50',
        ]);

        $supplier->update($request->all());

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Поставщик обновлён.');
    }

    public function destroy(Supplier $supplier)
    {
        if ($supplier->animals()->count() > 0) {
            return back()->with('error', 'Нельзя удалить поставщика — есть привязанные животные.');
        }

        $supplier->delete();
        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Поставщик удалён.');
    }

    public function show(Supplier $supplier)
    {
        abort(404);
    }
}