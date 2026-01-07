<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsMonthlyExport; // ✅ INI YANG KURANG

class TransactionController extends Controller
{
    /**
     * ===============================
     * HALAMAN TRANSAKSI (PER ORDER)
     * ===============================
     */
    public function index()
    {
        $transactions = Transaction::with('order')
            ->select(
                'order_id',
                'customer_name',
                DB::raw('SUM(quantity) as qty'),
                DB::raw('SUM(total) as total'),
                DB::raw('MIN(transaction_date) as transaction_date')
            )
            ->groupBy('order_id', 'customer_name')
            ->orderByDesc('transaction_date')
            ->paginate(5); // ✅ PAGINATION

        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * ===============================
     * TRANSAKSI MANUAL (ADMIN)
     * ===============================
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'price'      => 'required|numeric|min:0',
            'note'       => 'nullable|string',
        ]);

        $product  = Product::findOrFail($request->product_id);
        $quantity = (int) $request->quantity;
        $price    = (int) $request->price;

        Transaction::create([
            'customer_name'    => 'Manual',
            'product_id'       => $product->id,
            'quantity'         => $quantity,
            'price'            => $price,
            'total'            => $price * $quantity,
            'transaction_date' => now(),
            'type'             => 'sale',
            'note'             => $request->note,
        ]);

        $product->decrement('stock', $quantity);

        return redirect()
            ->route('admin.transactions.index')
            ->with('success', 'Transaksi manual berhasil dicatat.');
    }

    /**
     * ===============================
     * HAPUS TRANSAKSI (PER ORDER)
     * ===============================
     */
    public function destroy($orderId)
    {
        $transactions = Transaction::where('order_id', $orderId)->get();

        foreach ($transactions as $trx) {
            if ($trx->product) {
                $trx->product->increment('stock', $trx->quantity);
            }
            $trx->delete();
        }

        return redirect()
            ->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * ===============================
     * HALAMAN LAPORAN
     * ===============================
     */
    public function reportPage(Request $request)
    {
        $dateFrom = $request->query('from');
        $dateTo   = $request->query('to');

        $query = Transaction::query();

        if ($dateFrom) {
    $query->where('transaction_date', '>=', Carbon::parse($dateFrom)->startOfDay());
}

if ($dateTo) {
    $query->where('transaction_date', '<=', Carbon::parse($dateTo)->endOfDay());
}


        $transactions = $query
            ->select(
                'order_id',
                'customer_name',
                DB::raw('SUM(quantity) as qty'),
                DB::raw('SUM(total) as total'),
                DB::raw('MIN(transaction_date) as transaction_date')
            )
            ->groupBy('order_id', 'customer_name')
            ->orderByDesc('transaction_date')
            ->get();

        $totalRevenue = $transactions->sum('total');

        return view('admin.reports.transactions', compact(
            'transactions',
            'totalRevenue',
            'dateFrom',
            'dateTo'
        ));
    }

    
    public function exportPdfMonthly(Request $request)
{
    $month = $request->query('month'); // format: 2025-12

    abort_if(!$month, 404);

    [$year, $monthNumber] = explode('-', $month);

    $startDate = Carbon::create($year, $monthNumber, 1)->startOfMonth();
    $endDate   = Carbon::create($year, $monthNumber, 1)->endOfMonth();

    $transactions = Transaction::with('product')
        ->whereBetween('transaction_date', [$startDate, $endDate])
        ->orderBy('transaction_date')
        ->get()
        ->groupBy('order_id');

    $totalRevenue = $transactions->flatten()->sum('total');

    $pdf = Pdf::loadView('admin.transactions.report-pdf', [
        'transactions' => $transactions,
        'totalRevenue' => $totalRevenue,
        'dateFrom'     => $startDate->format('d M Y'),
        'dateTo'       => $endDate->format('d M Y'),
        'generatedAt'  => now()->format('d M Y H:i'),
    ])->setPaper('a4', 'portrait');

    return $pdf->download(
        'laporan-penjualan-' . $startDate->format('F-Y') . '.pdf'
    );
}
public function exportExcelMonthly(Request $request)
{
    $month = $request->query('month'); // contoh: 2025-12
    abort_if(!$month, 404);

    return Excel::download(
        new TransactionsMonthlyExport($month),
        'laporan-penjualan-' . $month . '.xlsx'
    );
}

}
 