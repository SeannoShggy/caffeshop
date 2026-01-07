@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@push('styles')
<style>
    /* stat cards (tetap sederhana) */
    .stat-card {
        border-radius: 10px;
        background: #0f172a;
        color: #fff;
        padding: 12px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:14px;
    }
    .stat-card .value { font-weight:700; font-size:1.1rem; }

    /* card wrapper mirip halaman kategori */
    .card-compact {
        background: #fff;
        border-radius: 8px;
        border: 1px solid rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 18px;
    }
    .card-compact .card-header {
        background: #0b1220;
        color: #fff;
        padding: 10px 14px;
        font-weight:600;
    }
    .card-compact .card-sub {
        background: transparent;
        color: #94a3b8;
        font-size: .85rem;
        padding: 6px 14px;
        border-bottom: 1px solid rgba(0,0,0,0.04);
    }
    .card-compact .card-body {
        padding: 6px 0;
    }

    /* baris kompak: nama kiri, value kanan */
    .row-item {
        display:flex;
        justify-content:space-between;
        align-items:center;
        padding:10px 16px;
        border-bottom: 1px solid rgba(0,0,0,0.04);
        font-size: .95rem;
    }
    .row-item:last-child { border-bottom: none; }

    .row-item .left { color:#111827; }
    .row-item .right { color:#111827; font-weight:700; white-space:nowrap; }

    /* badge stock kecil */
    .badge-stock {
        background: #ffde59;
        padding: 4px 8px;
        border-radius: 12px;
        color: #111827;
        font-weight:700;
        font-size: .86rem;
    }

    /* responsive tweaks */
    @media (max-width: 767px) {
        .row-item { padding: 8px 12px; font-size:.9rem; }
    }
</style>
@endpush

@section('content')
    {{-- STAT CARDS --}}
    <div class="row">
        <!-- NOTE: added col-6 so on small screens there are 2 cards per row -->
        <div class="col-6 col-md-6 col-lg-3 mb-2">
            <div class="stat-card">
                <div>
                    <div style="font-size:.85rem;color:#cbd5e1">Total Produk</div>
                    <div class="value">{{ $totalProducts ?? 0 }}</div>
                </div>
                <div style="background:#0ea5e9;padding:8px;border-radius:8px;color:#fff;">
                    <i class="fas fa-mug-hot"></i>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-6 col-lg-3 mb-2">
            <div class="stat-card">
                <div>
                    <div style="font-size:.85rem;color:#cbd5e1">Total Kategori</div>
                    <div class="value">{{ $totalCategories ?? 0 }}</div>
                </div>
                <div style="background:#22c55e;padding:8px;border-radius:8px;color:#fff;">
                    <i class="fas fa-cubes"></i>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-6 col-lg-3 mb-2">
            <div class="stat-card">
                <div>
                    <div style="font-size:.85rem;color:#cbd5e1">Stok Rendah</div>
                    <div class="value">{{ $lowStockCount ?? 0 }}</div>
                </div>
                <div style="background:#f59e0b;padding:8px;border-radius:8px;color:#fff;">
                    <i class="fas fa-box-open"></i>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-6 col-lg-3 mb-2">
            <div class="stat-card">
                <div>
                    <div style="font-size:.85rem;color:#cbd5e1">Total Pemasukan</div>
                    <div class="value">Rp {{ number_format($totalRevenue ?? 0,0,',','.') }}</div>
                </div>
                <div style="background:#7c3aed;padding:8px;border-radius:8px;color:#fff;">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN ROW: Produk Stok Rendah + Transaksi Terbaru --}}
    <div class="row">
        {{-- Produk Stok Rendah --}}
        <div class="col-lg-7">
            <div class="card-compact">
                <div class="card-header">Produk Stok Rendah</div>
                <div class="card-body">
                    @if(($lowStockProducts ?? collect())->count() === 0)
                        <div class="row-item"><div class="left">Tidak ada produk</div><div class="right">-</div></div>
                    @else
                        @foreach($lowStockProducts as $product)
                            <div class="row-item">
                                <div class="left">{{ $product->name }}</div>
                                <div class="right">
                                    <span class="badge-stock">{{ $product->stock }} pcs</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        {{-- Transaksi Terbaru --}}
        <div class="col-lg-5">
            <div class="card-compact">
                <div class="card-header">Transaksi Terbaru</div>
                <div class="card-body">
                    @if(empty($latestTransactions) || count($latestTransactions) === 0)
                        <div class="row-item"><div class="left">Belum ada transaksi</div><div class="right">-</div></div>
                    @else
                        @foreach($latestTransactions as $tx)
                            <div class="row-item">
                                <div class="left">{{ $tx['name'] }} <span style="color:#6b7280;font-weight:600;font-size:.82rem;margin-left:8px;">· {{ $tx['qty'] }}x</span></div>
                                <div class="right">Rp {{ number_format($tx['amount'],0,',','.') }}</div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Produk Terlaris (full width) --}}
    <div class="row mt-3">
        <div class="col-12">
            <div class="card-compact">
                <div class="card-header">Produk Terlaris</div>
                <div class="card-body">
                    @if(($topProducts ?? collect())->count() === 0)
                        <div class="row-item"><div class="left">Belum ada data penjualan</div><div class="right">-</div></div>
                    @else
                        @foreach($topProducts as $item)
                            <div class="row-item">
                                <div class="left">{{ $item->product->name ?? '-' }}</div>
                                <div class="right">{{ $item->total_qty }}x · Rp {{ number_format($item->total_sales,0,',','.') }}</div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
