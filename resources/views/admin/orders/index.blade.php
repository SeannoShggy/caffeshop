@extends('admin.layouts.app')

@section('title', 'Pesanan')
@section('page_title', 'Pesanan')

@push('styles')
<style>
.table-clean th, .table-clean td {
    padding: 12px 16px;
    font-size: .9rem;
}
.table-clean thead th {
    background:#0f0f1d;
    color:white;
}
.badge-pending {
    background:#fef3c7;
    color:#92400e;
    padding:6px 12px;
    border-radius:999px;
}
.badge-done {
    background:#dcfce7;
    color:#166534;
    padding:6px 12px;
    border-radius:999px;
}
.payment-proof-wrapper {
    margin-top: 8px;
}

.payment-proof-img {
    max-width: 220px;      /* Batas lebar */
    max-height: 220px;     /* Batas tinggi */
    width: 100%;
    object-fit: contain;  /* Gambar tidak kepotong */
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    padding: 6px;
    background: #f9fafb;
    transition: transform .2s ease, box-shadow .2s ease;
}

.payment-proof-img:hover {
    transform: scale(1.03);
    box-shadow: 0 6px 16px rgba(0,0,0,.12);
}

</style>
@endpush

@section('content')

<h4>Pesanan Masuk</h4>
<small class="text-muted">Pesanan yang belum / sedang diproses</small>

@if(session('success'))
<div class="alert alert-success mt-3">{{ session('success') }}</div>
@endif

<div class="card mt-3">
<div class="card-body p-0">
<table class="table table-clean mb-0">
    <thead>
        <tr>
            <th>No</th>
            <th>Hari / Tanggal</th>
            <th>Jam</th>
            <th>Nama</th>
            <th>Total</th>
            <th>Status</th>
            <th width="120">Aksi</th>
        </tr>
    </thead>
    <tbody id="ordersTable">
    @forelse($orders as $i => $order)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $order->created_at->translatedFormat('l, d M Y') }}</td>
            <td>{{ $order->created_at->format('H:i') }}</td>
            <td>{{ $order->customer_name }}</td>
            <td>Rp {{ number_format($order->total,0,',','.') }}</td>
            <td>
                @if($order->status === 'done')
                    <span class="badge-done">Selesai</span>
                @else
                    <span class="badge-pending">Belum Selesai</span>
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

        <div class="modal fade" id="detail{{ $order->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Pesanan</h5>
                        <button class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Nama:</strong> {{ $order->customer_name }}</p>
                        <p><strong>No HP:</strong> {{ $order->phone ?: '-' }}</p>
                        <p><strong>Hari / Tanggal:</strong> {{ $order->created_at->translatedFormat('l, d M Y') }}</p>
                        <p><strong>Jam:</strong> {{ $order->created_at->format('H:i') }}</p>

                        <hr>
                        <h6>Pesanan</h6>
                        @foreach($order->cart as $item)
                            <div class="d-flex justify-content-between border-bottom py-1">
                                <div>{{ $item['name'] }} <small class="text-muted">× {{ $item['qty'] }}</small></div>
                                <div>Rp {{ number_format($item['price'] * $item['qty'],0,',','.') }}</div>
                            </div>
                        @endforeach

                        <hr>
                        <p><strong>Catatan:</strong><br>{{ $order->note ?: '-' }}</p>
                    </div>
                    <hr>
<h6>Bukti Pembayaran</h6>

@if($order->payment_proof)
<div class="payment-proof-wrapper">
    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
        <img 
            src="{{ asset('storage/' . $order->payment_proof) }}"
            class="payment-proof-img"
            alt="Bukti Pembayaran"
        >
    </a>
</div>
@else
<p class="text-muted">Belum ada bukti pembayaran</p>
@endif

                    <div class="modal-footer">
                        <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                            @csrf
                            @method('PATCH')
                            @if($order->status !== 'done')
                                <input type="hidden" name="status" value="done">
                                <button class="btn btn-success">Tandai Selesai</button>
                            @else
                                <input type="hidden" name="status" value="pending">
                                <button class="btn btn-warning">Tandai Belum Selesai</button>
                            @endif
                        </form>
                        <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <tr>
            <td colspan="7" class="text-center text-muted py-4">
                Belum ada pesanan
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
</div>
</div>

@endsection

<audio id="orderSound" preload="auto">
    <source src="{{ asset('sounds/notif.wav') }}" type="audio/wav">
</audio>

<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>



