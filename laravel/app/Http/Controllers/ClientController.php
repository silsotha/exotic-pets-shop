<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::withCount('sales')
            ->with('user')
            ->orderByDesc('registration_date')
            ->orderByDesc('client_id')
            ->paginate(15);

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
                'regex:/^[\p{L}\s\-]+$/u',
            ],
            'phone' => [
                'required',
                'string',
                'regex:/^\+7\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}$/',
            ],
            'email' => [ // для учебного проекта проверка без dns
                'required',
                'email',
                'max:100',
                'unique:clients,email',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
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

            'phone.required' => 'Введите телефон клиента.',
            'phone.regex' => 'Неполный номер телефона. Формат: +7 (999) 999-99-99',

            'email.required' => 'Введите Email клиента. Он будет использоваться как логин.',
            'email.email' => 'Введите корректный адрес почты.',
            'email.unique' => 'Этот Email уже занят.',

            'password.required' => 'Введите пароль для аккаунта клиента.',
            'password.confirmed' => 'Пароли не совпадают.',

            'passport_data.regex' => 'Формат паспорта: 4 цифры, пробел, 6 цифр (4516 123456).',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'клиент',
                'employee_id' => null,
            ]);

            Client::create([
                'user_id' => $user->id,
                'full_name' => $validated['full_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'passport_data' => $validated['passport_data'] ?? null,
                'registration_date' => now()->toDateString(),
            ]);
        });

        if ($request->query('back') === 'sale') {
            return redirect()->route('sales.create')
                ->with('success', 'Клиент добавлен, аккаунт для входа создан.');
        }

        return redirect()->route('clients.index')
            ->with('success', 'Клиент добавлен, аккаунт для входа создан.');
    }

    public function edit(Client $client)
    {
        $client->load(['sales.animal.species', 'user']);

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
            'email' => [ // для учебного проекта проверка без dns
                'required',
                'email',
                'max:100',
                'unique:clients,email,' . $client->client_id . ',client_id',
                'unique:users,email,' . $client->user_id,
            ],
            'password' => [
                'nullable',
                'confirmed',
                Rules\Password::defaults(),
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

            'email.required' => 'Введите Email клиента.',
            'email.email' => 'Введите корректный адрес почты.',
            'email.unique' => 'Этот Email уже занят.',

            'password.confirmed' => 'Пароли не совпадают.',

            'passport_data.regex' => 'Формат паспорта: 4 цифры, пробел, 6 цифр (4516 123456).',
        ]);

        DB::transaction(function () use ($validated, $client) {
            $client->update([
                'full_name' => $validated['full_name'],
                'phone' => $validated['phone'] ?? null,
                'email' => $validated['email'],
                'passport_data' => $validated['passport_data'] ?? null,
            ]);

            if ($client->user) {
                $userData = [
                    'name' => $validated['full_name'],
                    'email' => $validated['email'],
                ];

                if (!empty($validated['password'])) {
                    $userData['password'] = Hash::make($validated['password']);
                }

                $client->user->update($userData);
            } else {
                $user = User::create([
                    'name' => $validated['full_name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password'] ?? 'client12345'),
                    'role' => 'клиент',
                    'employee_id' => null,
                ]);

                $client->update(['user_id' => $user->id]);
            }
        });

        return redirect()->route('clients.index')
            ->with('success', 'Данные клиента и аккаунта обновлены.');
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