<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Sale;
use App\Models\Species;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // счётчики по статусам
        $stats = Animal::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalAnimals    = Animal::count();
        $onQuarantine    = $stats['карантин']   ?? 0;
        $availableForSale= $stats['на продажу'] ?? 0;
        $sold            = $stats['продано']    ?? 0;
        $writtenOff      = $stats['списано']    ?? 0;

        // выручка за текущий месяц
        $revenueThisMonth = Sale::whereMonth('sale_date', now()->month)
            ->whereYear('sale_date', now()->year)
            ->sum('total_price');

        // выручка за всё время
        $revenueTotal = Sale::sum('total_price');

        // продажи по месяцам (последние 6 месяцев) — для графика
        $salesByMonth = Sale::select(
                DB::raw("TO_CHAR(sale_date, 'YYYY-MM') as month"),
                DB::raw('count(*) as count'),
                DB::raw('sum(total_price) as revenue')
            )
            ->where('sale_date', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // топ-5 продаваемых видов
        $topSpecies = Sale::select('species.name', DB::raw('count(*) as total'))
            ->join('animals', 'sales.animal_id', '=', 'animals.animal_id')
            ->join('species', 'animals.species_id', '=', 'species.species_id')
            ->groupBy('species.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // последние 5 продаж
        $recentSales = Sale::with(['animal.species', 'client'])
            ->orderByDesc('sale_date')
            ->limit(5)
            ->get();

        // животные на карантине дольше нормы
        $overdueQuarantine = Animal::with('species')
            ->where('status', 'карантин')
            ->whereRaw('arrival_date + (species.quarantine_days || \' days\')::interval < NOW()')
            ->join('species', 'animals.species_id', '=', 'species.species_id')
            ->select('animals.*')
            ->get();

        return view('dashboard', compact(
            'totalAnimals', 'onQuarantine', 'availableForSale',
            'sold', 'writtenOff', 'revenueThisMonth', 'revenueTotal',
            'salesByMonth', 'topSpecies', 'recentSales', 'overdueQuarantine'
        ));
    }
    public function exportSales(Request $request)
    {
        $sales = Sale::with(['animal.species', 'client', 'employee'])
            ->orderByDesc('sale_date')
            ->get();

        $filename = 'sales_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($sales) {
            $file = fopen('php://output', 'w');
            // BOM для корректного открытия в Excel
            fputs($file, "\xEF\xBB\xBF");

            fputcsv($file, ['№', 'Дата', 'Животное', 'Клиент', 'Продавец', 'Сумма', 'Оплата', 'Договор'], ';');

            foreach ($sales as $sale) {
                fputcsv($file, [
                    $sale->sale_id,
                    $sale->sale_date,
                    $sale->animal->species->name,
                    $sale->client->full_name,
                    $sale->employee->full_name,
                    $sale->total_price,
                    $sale->payment_method,
                    $sale->contract_number ?? '',
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}