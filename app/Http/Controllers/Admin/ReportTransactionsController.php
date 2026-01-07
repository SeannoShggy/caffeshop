<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportTransactionController extends Controller
{
    public function index(Request $request)
{
    $dateFrom = $request->from;
    $dateTo   = $request->to;

    $query = Transaction::query();

    if ($dateFrom && $dateTo) {
        $query->whereBetween('transaction_date', [
            Carbon::parse($dateFrom)->startOfDay(),
            Carbon::parse($dateTo)->endOfDay(),
        ]);
    }

    $transactionsRaw = $query
        ->orderBy('transaction_date', 'asc')
        ->get();

    // PASTI COLLECTION
    $transactions = $transactionsRaw->count()
        ? $transactionsRaw->groupBy('order_id')
        : collect();

    $totalRevenue = $transactionsRaw->sum('total');

    return view('admin.reports.transactions', compact(
        'transactions',
        'totalRevenue',
        'dateFrom',
        'dateTo'
    ));
}

}
