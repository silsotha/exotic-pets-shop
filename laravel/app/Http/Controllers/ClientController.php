<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::withCount('sales')->orderBy('full_name')->paginate(15);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'passport_data' => 'nullable|string|max:50',
        ]);

        $validated['registration_date'] = now()->toDateString();
        Client::create($validated);

        // если пришли со страницы продажи — возвращаемся туда
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
            'full_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'passport_data' => 'nullable|string|max:50',
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