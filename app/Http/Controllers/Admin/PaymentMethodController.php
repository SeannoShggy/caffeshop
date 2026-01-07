<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /* =======================
       LIST
    ======================= */
    public function index()
    {
        $methods = PaymentMethod::orderBy('id')->get();
        return view('admin.payment_methods.index', compact('methods'));
    }

    /* =======================
       CREATE FORM
    ======================= */
    public function create()
    {
        return view('admin.payment_methods.create');
    }

    /* =======================
       STORE
    ======================= */
    public function store(Request $request)
    {
        return $this->savePaymentMethod(new PaymentMethod(), $request);
    }

    /* =======================
       EDIT FORM
    ======================= */
    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payment_methods.edit', [
            'method' => $paymentMethod
        ]);
    }

    /* =======================
       UPDATE
    ======================= */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        return $this->savePaymentMethod($paymentMethod, $request);
    }

    /* =======================
       DELETE
    ======================= */
    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();

        return redirect()
            ->route('admin.payment_methods.index')
            ->with('success', 'Metode pembayaran dihapus');
    }

    /* =======================
       CORE LOGIC (SATU TEMPAT)
    ======================= */
    private function savePaymentMethod(PaymentMethod $paymentMethod, Request $request)
    {
        $request->validate([
            'method'       => 'required|in:bank,ewallet,qris',
            'display_name' => 'required|string',
            'number'       => 'nullable|string',
            'qris_image'   => 'nullable|image|max:2048',
        ]);

        $details = [
            'method' => $request->method,
            'name'   => $request->display_name,
        ];

        // BANK / EWALLET
        if (in_array($request->method, ['bank', 'ewallet'])) {
            if ($request->number) {
                $details['number'] = $request->number;
            }
        }

        // QRIS
        if ($request->method === 'qris') {
            if ($request->hasFile('qris_image')) {
                $path = $request->file('qris_image')->store('qris', 'public');
                $details['qrcode_url'] = '/storage/' . $path;
            } else {
                // kalau update & tidak upload ulang → pakai QR lama
                $details['qrcode_url'] = $paymentMethod->details['qrcode_url'] ?? null;
            }
        }

        $paymentMethod->fill([
            'name'    => $request->display_name,
            'type'    => $request->method,
            'details' => $details,
            'active'  => $request->has('active'),
        ])->save();

        // ✅ INI YANG DIBENERIN
        return redirect()
            ->route('admin.payment_methods.index')
            ->with('success', 'Metode pembayaran berhasil disimpan');
    }
}
