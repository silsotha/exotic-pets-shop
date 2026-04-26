<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::withCount('sales')->orderByDesc('registration_date')->orderByDesc('client_id')->paginate(15);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[\p{L}\s\-]+$/u', // только буквы, пробелы, дефисы
            ],
            'phone' => [
                'required',
                'string',
                'regex:/^\+7\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}$/',
            ],
            'email' => [
                'nullable',
                'email:rfc,dns',
                'max:100',
                'unique:clients,email', // уникальность в БД
            ],
            'passport_data' => [
                'nullable',
                'string',
                'regex:/^\d{4}\s\d{6}$/', // формат: 4516 123456
            ],
        ], [
                'full_name.required' => 'Введите ФИО клиента.',
                'full_name.min' => 'ФИО должно содержать не менее 3 символов.',
                'full_name.regex' => 'ФИО может содержать только буквы, пробелы и дефисы.',
                'phone.regex' => 'Неполный номер телефона. Формат: +7 (999) 999-99-99',
                'email.email' => 'Введите корректный адрес почты.',
                'email.unique' => 'Этот Email уже занят.',
                'passport_data.regex' => 'Формат паспорта: 4 цифры, пробел, 6 цифр (4516 123456).',
            ]);

        $validated['registration_date'] = now()->toDateString();
        Client::create($validated);

        if ($request->query('back') === 'sale') {
            return redirect()->route('sales.create')
                ->with('success', 'Клиент добавлен.');
        }

        return redirect()->route('clients.index')
            ->with('success', 'Клиент добавлен.');
    }

    public function edit(Client $client)
    {
        $client->load(['sales.animal.species']);
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'full_name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[\p{L}\s\-]+$/u',
            ],
            'phone' => [
                'nullable',
                'string',
                'regex:/^\+7\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}$/',
            ],
            'email' => [
                'nullable',
                'email:rfc,dns',
                'max:100',
                'unique:clients,email,' . $client->client_id . ',client_id', // исключаем себя
            ],
            'passport_data' => [
                'nullable',
                'string',
                'regex:/^\d{4}\s\d{6}$/',
            ],
        ], [
                'full_name.required' => 'Введите ФИО клиента.',
                'full_name.min' => 'ФИО должно содержать не менее 3 символов.',
                'full_name.regex' => 'ФИО может содержать только буквы, пробелы и дефисы.',
                'phone.regex' => 'Неполный номер телефона. Формат: +7 (999) 999-99-99',
                'email.email' => 'Введите корректный адрес почты.',
                'email.unique' => 'Этот Email уже занят.',
                'passport_data.regex' => 'Формат паспорта: 4 цифры, пробел, 6 цифр (4516 123456).',
            ]);

        $client->update($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Данные клиента обновлены.');
    }

    public function show(Client $client)
    {
        abort(404);
    }
    public function destroy(Client $client)
    {
        abort(404);
    }
}