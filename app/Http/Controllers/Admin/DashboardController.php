<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        // Stat atas
        $totalProducts    = Product::count();
        $totalCategories  = Category::count();
        $totalRevenue     = Transaction::sum('total');

        // Produk stok rendah (misal stok < 10)
        $lowStockProducts = Product::where('stock', '<', 10)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();
        $lowStockCount = $lowStockProducts->count();

        // Transaksi terbaru (kanan)
        $latestTransactions = Transaction::with('product')
            ->orderByDesc('transaction_date')
            ->take(5)
            ->get()
            ->map(function ($trx) {
                return [
                    'name'   => $trx->product->name ?? '-',
                    'date'   => $trx->transaction_date?->format('Y-m-d'),
                    'qty'    => $trx->quantity,
                    'amount' => $trx->total,
                ];
            })
            ->toArray();

        // 🔥 Produk terlaris (berdasar total qty terjual)
        $topProducts = Transaction::selectRaw('product_id, SUM(quantity) as total_qty, SUM(total) as total_sales')
            ->groupBy('product_id')
            ->with('product')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalRevenue',
            'lowStockProducts',
            'lowStockCount',
            'latestTransactions',
            'topProducts', // <--- jangan lupa kirim ke view
        ));
    }
}
