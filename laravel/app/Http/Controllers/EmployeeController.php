<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::orderBy('full_name')->paginate(15);
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:100',
            'role'      => 'required|in:продавец,ветврач,администратор',
            'phone'     => 'nullable|string|max:20',
            'hire_date' => 'required|date',
        ]);

        Employee::create($request->all());

        return redirect()->route('admin.employees.index')
            ->with('success', 'Сотрудник добавлен.');
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'full_name' => 'required|string|max:100',
            'role'      => 'required|in:продавец,ветврач,администратор',
            'phone'     => 'nullable|string|max:20',
            'hire_date' => 'required|date',
        ]);

        $employee->update($request->all());

        return redirect()->route('admin.employees.index')
            ->with('success', 'Данные сотрудника обновлены.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('admin.employees.index')
            ->with('success', 'Сотрудник удалён.');
    }

    public function show(Employee $employee) { abort(404); }
}