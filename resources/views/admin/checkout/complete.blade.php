<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Status Pesanan</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
aside,.sidebar,.main-sidebar,.navbar,.nav-header{display:none!important;}
.wrapper,.content-wrapper{margin-left:0!important;width:100%!important;}
body{background:#f4f6fb;font-size:14px;}
.complete{max-width:720px;margin:50px auto;padding:0 16px;}
.card{border:none;border-radius:16px;}
.card-header{background:white;border-bottom:1px solid #e5e7eb;}

/* Floating WhatsApp */
.wa-float{
    position:fixed;
    right:20px;
    bottom:20px;
    z-index:999;
}
.wa-float a{
    width:56px;
    height:56px;
    background:#25d366;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 8px 20px rgba(0,0,0,.25);
}
.wa-float img{
    width:32px;
    height:32px;
}
</style>
</head>

<body>

@php
    // =====================
    // DATA
    // =====================
    $adminWa = '6282117567075'; // GANTI NO ADMIN

    // Rincian pesanan
    $items = "";
    foreach($order->cart as $item){
        $items .= "- {$item['name']} x{$item['qty']} = Rp "
            . number_format($item['price'] * $item['qty'],0,',','.') . "\n";
    }

    $catatan = $order->note ?? '-';
    $paymentMethod = $order->payment_method ?? 'Transfer';

    // PESAN WA (JANGAN DI urlencode PER BARIS)
    $waText =
"Halo Admin 

Saya ingin konfirmasi pesanan:

No Pesanan: {$order->order_id}
Nama: {$order->customer_name}
No HP: {$order->phone}

Rincian Pesanan:
{$items}
Total: Rp ".number_format($order->total,0,',','.')."

Metode Pembayaran: {$paymentMethod}
Catatan: {$catatan}

Terima kasih ";

    $waLink = 'https://wa.me/'.$adminWa.'?text='.urlencode($waText);
@endphp

<div class="complete">
<div class="card shadow-sm">

<div class="card-header">
    <h5 class="mb-0">Terima Kasih — Pesanan Diterima</h5>
</div>

<div class="card-body">

<span class="badge bg-success mb-2 d-inline-block">
    Sudah Dibayar
</span>

<div class="text-muted small mb-3">
    Pesanan Anda sedang diproses
</div>

<h6>No. Pesanan</h6>
<p class="fw-bold">{{ $order->order_id }}</p>

<p class="mb-1"><strong>Nama:</strong> {{ $order->customer_name }}</p>
<p class="mb-3"><strong>No. HP / WA:</strong> {{ $order->phone }}</p>

<hr>

<h6>Rincian Pesanan</h6>

@foreach($order->cart as $item)
<div class="d-flex justify-content-between py-1 border-bottom">
    <div>
        {{ $item['name'] }}
        <small class="text-muted">× {{ $item['qty'] }}</small>
    </div>
    <div>
        Rp {{ number_format($item['price'] * $item['qty'],0,',','.') }}
    </div>
</div>
@endforeach

<div class="d-flex justify-content-between mt-3">
    <strong>Total</strong>
    <strong>Rp {{ number_format($order->total,0,',','.') }}</strong>
</div>

<hr>
<p class="mb-1"><strong>Metode Pembayaran:</strong> {{ $paymentMethod }}</p>
<p class="mb-0"><strong>Catatan:</strong> {{ $catatan }}</p>

@if($order->payment_proof)
<hr>
<h6>Bukti Pembayaran</h6>
<img src="{{ asset('storage/'.$order->payment_proof) }}"
     class="img-fluid rounded border">
@endif

<div class="mt-4">
    <a href="{{ route('menu') }}" class="btn btn-outline-secondary">
        Kembali ke Menu
    </a>
</div>

</div>
</div>
</div>

<!-- Floating WA -->
<div class="wa-float">
    <a href="{{ $waLink }}" target="_blank">
        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
    </a>
</div>

</body>
</html>
