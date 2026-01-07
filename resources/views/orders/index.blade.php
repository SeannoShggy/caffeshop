@extends('admin.layouts.app')
    

@section('title', 'Pesanan')
@section('page_title', 'Pesanan')

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
.badge-status {
    padding:6px 10px;
    border-radius:999px;
    font-size:.75rem;
}
.badge-pending { background:#fef3c7;color:#92400e; }
.badge-done { background:#dcfce7;color:#166534; }
</style>
@endpush

@section('content')

<div class="d-flex justify-content-between mb-3">
    <div>
        <h4 class="mb-0">Pesanan</h4>
        <small class="text-muted">Daftar pesanan masuk</small>
    </div>
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
            <th>Jam Pesanan</th>
            <th>Nama</th>
            <th>Total</th>
            <th>Status</th>
            <th width="140">Aksi</th>
        </tr>
    </thead>
    <tbody>
    @forelse($orders as $i => $order)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
            <td>{{ $order->customer_name }}</td>
            <td>Rp {{ number_format($order->total,0,',','.') }}</td>
            <td>
                @if($order->status === 'done')
                    <span class="badge-status badge-done">Selesai</span>
                @else
                    <span class="badge-status badge-pending">Belum Selesai</span>
                @endif
            </td>
            <td>
                <button class="btn btn-sm btn-outline-primary"
                        data-toggle="modal"
                        data-target="#detail{{ $order->id }}">
                    Detail
                </button>
            </td>
        </tr>

        {{-- MODAL DETAIL --}}
        <div class="modal fade" id="detail{{ $order->id }}">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            Detail Pesanan #{{ $order->order_id }}
                        </h5>
                        <button class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body">
                        <p><strong>Nama:</strong> {{ $order->customer_name }}</p>
                        <p><strong>No HP:</strong> {{ $order->phone }}</p>

                        <hr>

                        <h6>Pesanan</h6>
                        @foreach($order->cart as $item)
                            <div class="d-flex justify-content-between border-bottom py-1">
                                <div>
                                    {{ $item['name'] }}
                                    <small class="text-muted">× {{ $item['qty'] }}</small>
                                </div>
                                <div>
                                    Rp {{ number_format($item['price']*$item['qty'],0,',','.') }}
                                </div>
                            </div>
                        @endforeach

                        <hr>

                        <p><strong>Catatan:</strong><br>
                        {{ $order->note ?: '-' }}</p>
                    </div>
                    

                    <div class="modal-footer">
                       <form method="POST"
      action="{{ route('admin.orders.status', $order) }}">
    @csrf
    @method('PATCH')

    <button class="btn btn-success"
            onclick="return confirm('Pesanan selesai & masuk transaksi?')">
        Selesai
    </button>
</form>


                        <button class="btn btn-secondary" data-dismiss="modal">
                            Tutup
                        </button>
                    </div>

                </div>
            </div>
        </div>

    @empty
        <tr>
            <td colspan="6" class="text-center text-muted py-4">
                Belum ada pesanan.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
</div>
</div>

@endsection
