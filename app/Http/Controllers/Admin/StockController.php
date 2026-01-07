<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    // List semua produk + stok
    public function index()
    {
        $products = Product::orderBy('name')->get();

        return view('admin.stock.index', compact('products'));
    }

    // Update stok satu produk
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $product->update([
            'stock' => $request->stock,
        ]);

        return redirect()->route('admin.stock.index')
            ->with('success', 'Stok produk berhasil diupdate.');
    }
}
