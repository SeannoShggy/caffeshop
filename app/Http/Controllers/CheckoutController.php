<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\Product;
use App\Models\PaymentMethod;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        $cart = json_decode($request->cart, true);

        if (!is_array($cart) || count($cart) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang kosong'
            ], 422);
        }

        $total = collect($cart)->sum(fn ($item) =>
            ($item['price'] ?? 0) * ($item['qty'] ?? 1)
        );

        session([
            'pending_order' => [
                'order_id'      => 'ORD' . now()->format('YmdHis') . Str::random(4),
                'customer_name' => $request->customer_name ?? 'Pelanggan',
                'phone'         => $request->phone ?? '',
                'note'          => $request->note ?? '',
                'cart'          => $cart,
                'total'         => $total,
                'created_at'    => now()->toDateTimeString(),
            ]
        ]);

        return response()->json([
            'success' => true,
            'redirect' => route('checkout.review')
        ]);
    }

    public function review()
    {
        $order = session('pending_order');
        if (!$order) {
            return redirect()->route('menu');
        }

        return view('admin.checkout.review', [
            'order' => $order,
            'paymentMethods' => PaymentMethod::where('active', 1)->get()
        ]);
    }

    public function submitProof(Request $request)
    {
        $pending = session('pending_order');
        if (!$pending) {
            return response()->json([
                'success' => false,
                'message' => 'Session habis'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|exists:payment_methods,id',
            'proof' => 'required|image|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            DB::transaction(function () use ($request, $pending, &$order) {

                // 🔥 CEK & KURANGI STOK
                foreach ($pending['cart'] as $item) {
                    $product = Product::lockForUpdate()->find($item['id']);

                    if (!$product) {
                        throw new \Exception('Produk tidak ditemukan');
                    }

                    if ($product->stock < $item['qty']) {
                        throw new \Exception(
                            "Stok {$product->name} tidak mencukupi"
                        );
                    }

                    // 🔥 INI PENGURANGAN STOK
                    $product->decrement('stock', $item['qty']);
                }

                $path = $request->file('proof')
                    ->store('payment_proofs', 'public');

                $method = PaymentMethod::findOrFail(
                    $request->payment_method
                );

                // SIMPAN ORDER
                $order = Order::create([
                    'order_id'       => $pending['order_id'],
                    'customer_name'  => $pending['customer_name'],
                    'phone'          => $pending['phone'],
                    'cart'           => $pending['cart'],
                    'payment_method' => $method->name,
                    'note'           => $pending['note'],
                    'total'          => $pending['total'],
                    'status'         => 'pending',
                    'payment_status' => 'paid',
                    'payment_proof'  => $path,
                ]);
            });

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }

        session()->forget('pending_order');
        session(['completed_order_id' => $order->id]);

        return response()->json([
            'success' => true,
            'redirect' => route('checkout.complete')
        ]);
    }

    public function complete()
    {
        $id = session('completed_order_id');

        if (!$id) {
            return redirect()->route('menu');
        }

        $order = Order::findOrFail($id);

        return view('admin.checkout.complete', compact('order'));
    }
}
