@extends('admin.layouts.app')


@section('title', 'Transaksi')
@section('page_title', 'Transaksi')

@push('styles')
<style>
.table-clean th, .table-clean td {
    padding: 12px 16px;
    font-size: .9rem;
    vertical-align: middle;
}
.table-clean thead th {
    background:#0f0f1d;
    color:white;
}
/* Thumbnail bukti transfer */
.payment-proof-thumb {
    max-width: 160px;
    cursor: pointer;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    padding: 6px;
    background: #f9fafb;
    transition: all .2s ease;
}

.payment-proof-thumb:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 18px rgba(0,0,0,.15);
}

/* Modal image full */
.payment-proof-full {
    width: 100%;
    max-height: 80vh;
    object-fit: contain;
    border-radius: 12px;
}

/* Modal background biar fokus ke gambar */
.modal-content {
    border-radius: 14px;
}

.modal-body {
    padding: 12px;
}

/* Optional: cursor zoom */
.payment-proof-full {
    cursor: zoom-out;
}

/* Mobile friendly */
@media (max-width: 768px) {
    .payment-proof-thumb {
        max-width: 120px;
    }
}

</style>
@endpush

@section('content')

<div class="d-flex justify-content-between mb-3">
    <div>
        <h4 class="mb-0">Transaksi</h4>
        <small class="text-muted">Pesanan yang sudah selesai</small>
    </div>
</div>

{{-- ================= EXPORT BUTTONS ================= --}}
<div class="d-flex gap-2 mb-3">

    {{-- Export PDF --}}
    <form method="GET"
          action="{{ route('admin.transactions.export.pdf.monthly') }}"
          class="d-flex align-items-end gap-2">

        <div>
            <label class="form-label mb-1">Pilih Bulan</label>
            <input type="month" name="month" class="form-control" required>
        </div>

        <button class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Export PDF
        </button>
    </form>

    {{-- Export Excel --}}
    <form method="GET"
          action="{{ route('admin.transactions.export.excel.monthly') }}"
          class="d-flex align-items-end gap-2">

        <div>
            <label class="form-label mb-1">Pilih Bulan</label>
            <input type="month" name="month" class="form-control" required>
        </div>

        <button class="btn btn-success">
            <i class="fas fa-file-excel"></i> Export Excel
        </button>
    </form>

</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
<div class="card-body p-0">

<table class="table table-clean mb-0">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>Qty</th>
            <th>Total</th>
            <th width="120">Aksi</th>
        </tr>
    </thead>
    <tbody>

    @forelse($transactions as $i => $trx)
    <tr>
        <td>{{ $transactions->firstItem() + $i }}</td>
        <td>{{ $trx->transaction_date->format('d M Y H:i') }}</td>
        <td>{{ $trx->customer_name ?: 'Manual' }}</td>
        <td>{{ $trx->qty }}</td>
        <td>Rp {{ number_format($trx->total,0,',','.') }}</td>
        <td>
            <button class="btn btn-sm btn-outline-primary"
                    data-toggle="modal"
                    data-target="#detail{{ $trx->order_id }}">
                Detail
            </button>
        </td>
    </tr>

    {{-- MODAL DETAIL --}}
    <div class="modal fade" id="detail{{ $trx->order_id }}">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Transaksi</h5>
                    <button class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">
                    <p><strong>Tanggal:</strong> {{ $trx->transaction_date->format('d M Y') }}</p>
                    <p><strong>Jam:</strong> {{ $trx->transaction_date->format('H:i') }}</p>
                    <p><strong>Nama:</strong> {{ $trx->customer_name }}</p>
                    <p><strong>Total Produk:</strong> {{ $trx->qty }}</p>

                    <hr>
                    <h6>Pesanan</h6>

                    @if($trx->order && $trx->order->cart)
                        @foreach($trx->order->cart as $item)
                            <div class="d-flex justify-content-between border-bottom py-1">
                                <div>
                                    {{ $item['name'] }}
                                    <small class="text-muted">× {{ $item['qty'] }}</small>
                                </div>
                                <div>
                                    Rp {{ number_format($item['price'] * $item['qty'],0,',','.') }}
                                </div>
                            </div>
                        @endforeach
                    @endif
                    

                    <hr>
<h6>Bukti Transfer</h6>

@if($trx->order && $trx->order->payment_proof)
    <img src="{{ asset('storage/' . $trx->order->payment_proof) }}"
         class="payment-proof-thumb"
         data-toggle="modal"
         data-target="#proofModal{{ $trx->order_id }}"
         alt="Bukti Transfer">
@else
    <p class="text-muted mb-0">Belum ada bukti transfer</p>
@endif

                </div>
            </div>
        </div>
    </div>

    @empty
        <tr>
            <td colspan="6" class="text-center text-muted py-4">
                Belum ada transaksi
            </td>
        </tr>
    @endforelse

    </tbody>
</table>

{{-- ================= PAGINATION ================= --}}
@if ($transactions->hasPages())
    <div class="d-flex justify-content-center py-4">
        {{ $transactions->links('pagination::bootstrap-4') }}
    </div>
@endif


</div>
</div>

@endsection
