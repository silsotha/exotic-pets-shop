<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Services\FeedStockService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FeedStockController extends Controller
{
    public function store(Request $request, Feed $feed, FeedStockService $stockService): RedirectResponse
    {
        $operationTypes = array_keys(config('exotic.feed_operation_types', []));

        $validated = $request->validate([
            'operation_type' => ['required', Rule::in($operationTypes)],
            'quantity' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $positiveOperations = ['receipt', 'adjustment'];
        $quantityChange = in_array($validated['operation_type'], $positiveOperations, true)
            ? (int) $validated['quantity']
            : -(int) $validated['quantity'];

        $employeeId = auth()->user()->employee?->employee_id;

        $stockService->addMovement(
            $feed,
            $validated['operation_type'],
            $quantityChange,
            $employeeId,
            $validated['notes'] ?? null
        );

        return back()->with('success', 'Остаток корма обновлён.');
    }
}
