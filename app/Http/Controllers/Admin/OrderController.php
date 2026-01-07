<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * HALAMAN PESANAN (HANYA PENDING)
     */
    public function index()
    {
        $orders = Order::where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * TANDAI SELESAI → PINDAH KE TRANSAKSI
     */
    public function updateStatus(Request $request, Order $order)
    {
        // 1️⃣ update status order
        $order->update([
            'status' => 'done'
        ]);

        // 2️⃣ masukkan ke tabel transactions
        foreach ($order->cart as $item) {
            Transaction::create([
                'order_id'         => $order->id,
                'customer_name'    => $order->customer_name,
                'phone'            => $order->phone,
                'product_id'       => $item['id'] ?? null,
                'quantity'         => $item['qty'],
                'price'            => $item['price'],
                'total'            => $item['price'] * $item['qty'],
                'transaction_date' => now(),
                'type'             => 'sale',
                'note'             => $order->note,
            ]);
        }

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Pesanan selesai & masuk transaksi');
    }
}
