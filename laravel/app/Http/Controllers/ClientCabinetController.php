<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ClientCabinetController extends Controller
{
    public function index()
    {
        $client = Auth::user()->client;

        if (!$client) {
            abort(403, 'Профиль клиента не найден.');
        }

        $sales = $client->sales()
            ->with(['animal.species'])
            ->orderByDesc('sale_date')
            ->get();

        $totalSpent = $sales->sum('total_price');

        return view('client-cabinet.index', compact('client', 'sales', 'totalSpent'));
    }
}