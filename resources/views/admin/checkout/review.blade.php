<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Konfirmasi Pembayaran</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" href="{{ asset('logo seanspace.png') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
aside,.sidebar,.main-sidebar,.navbar,.nav-header{
    display:none!important;
}
.wrapper,.content-wrapper{
    margin-left:0!important;
    width:100%!important;
}
body{
    background:#f4f6fb;
    font-size:14px;
}
.checkout{
    max-width:1050px;
    margin:40px auto;
    padding:0 16px;
}
.card{
    border:none;
    border-radius:16px;
}
.card-body{
    padding:26px;
}
.header{
    display:flex;
    justify-content:space-between;
    border-bottom:1px solid #e5e7eb;
    padding-bottom:16px;
    margin-bottom:24px;
}
.order-id{
    background:#eef2ff;
    color:#3730a3;
    padding:6px 14px;
    border-radius:8px;
    font-weight:600;
}
.payment-box{
    border:1px solid #e5e7eb;
    border-radius:14px;
    padding:16px;
    margin-bottom:12px;
    cursor:pointer;
}
.payment-box.active{
    border-color:#4f46e5;
    background:#eef2ff;
}
.payment-detail{
    margin-left:26px;
    margin-top:10px;
    display:none;
}
.payment-detail img{
    max-width:180px;
    border-radius:10px;
}
.summary{
    background:#fafafa;
    border:1px solid #e5e7eb;
    border-radius:16px;
    padding:20px;
}
.btn-primary{
    background:#4f46e5;
    border:none;
    border-radius:10px;
}
</style>
</head>

<body>

<div class="checkout">
<div class="card shadow-sm">
<div class="card-body">

<div class="header">
    <div>
        <h5 class="mb-1">Caffeshop — Konfirmasi Pembayaran</h5>
        <small class="text-muted">Periksa data & unggah bukti transfer</small>
    </div>
    <div class="text-end">
        <div class="small">No. Pesanan</div>
        <div class="order-id">{{ $order['order_id'] }}</div>
        <div class="small text-muted mt-1">
            {{ \Carbon\Carbon::parse($order['created_at'])->diffForHumans() }}
        </div>
    </div>
</div>

<div class="row g-4">

<div class="col-lg-7">

<h6>Data Pemesan</h6>
<p class="mb-1"><strong>Nama:</strong> {{ $order['customer_name'] }}</p>
<p class="mb-1"><strong>No. HP / WA:</strong> {{ $order['phone'] ?: '-' }}</p>
<p class="mb-3"><strong>Catatan:</strong> {{ $order['note'] ?: '-' }}</p>

<form id="proofForm" action="{{ route('checkout.submit_proof') }}" method="POST" enctype="multipart/form-data">
@csrf

<h6 class="mb-3">Pilih Metode Pembayaran</h6>

@foreach($paymentMethods as $pm)
@php $d = $pm->details ?? []; @endphp

<div class="payment-box {{ $loop->first ? 'active' : '' }}">
<label class="d-flex gap-2 w-100">
<input type="radio" name="payment_method" value="{{ $pm->id }}" {{ $loop->first ? 'checked' : '' }}>

<div class="w-100">
<strong>{{ strtoupper($pm->name) }}</strong>

<div class="payment-detail" style="{{ $loop->first ? 'display:block' : '' }}">
@if(!empty($d['number']))
Nomor: <strong>{{ $d['number'] }}</strong><br>
@endif
@if(!empty($d['qrcode_url']))
<img src="{{ $d['qrcode_url'] }}">
@endif
</div>
</div>
</label>
</div>
@endforeach

<hr>

<h6>Upload Bukti Pembayaran</h6>
<input type="file" name="proof" class="form-control mb-3" required>

<button class="btn btn-primary" type="submit">
    Kirim Bukti & Selesaikan
</button>
<a href="{{ route('menu') }}" class="btn btn-outline-secondary ms-2">
    Kembali
</a>
</form>

</div>

<div class="col-lg-5">
<div class="summary">
<h6>Rincian Pesanan</h6>

@foreach($order['cart'] as $item)
<div class="d-flex justify-content-between mb-2">
<div>
{{ $item['name'] }}
<div class="small text-muted">×{{ $item['qty'] }}</div>
</div>
<strong>
Rp {{ number_format($item['price']*$item['qty'],0,',','.') }}
</strong>
</div>
@endforeach

<hr>
<div class="d-flex justify-content-between">
<strong>Total</strong>
<strong>Rp {{ number_format($order['total'],0,',','.') }}</strong>
</div>
</div>
</div>

</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.querySelectorAll('.payment-box').forEach(box=>{
    box.addEventListener('click',()=>{
        document.querySelectorAll('.payment-box').forEach(b=>{
            b.classList.remove('active');
            b.querySelector('.payment-detail').style.display='none';
        });
        box.classList.add('active');
        box.querySelector('input').checked = true;
        box.querySelector('.payment-detail').style.display='block';
    });
});

/* =======================
   AJAX SUBMIT (INI KUNCI)
======================= */
$('#proofForm').on('submit', function(e){
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: this.action,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success(res){
            if (res.redirect) {
                window.location.href = res.redirect;
            } else {
                alert('Bukti pembayaran berhasil dikirim');
            }
        },
        error(xhr){
            // ⬇️ INI KUNCI UTAMA
            if (xhr.status === 422 && xhr.responseJSON?.redirect) {
                window.location.href = xhr.responseJSON.redirect;
                return;
            }

            if (xhr.responseJSON?.message) {
                alert(xhr.responseJSON.message);
            } else {
                alert('Upload berhasil, tapi response tidak sesuai');
            }
        }
    });
});

</script>

</body>
</html>
