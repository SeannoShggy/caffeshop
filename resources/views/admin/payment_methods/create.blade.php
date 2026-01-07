@extends('admin.layouts.app')

@section('content')
<div class="container" style="max-width:650px">
    <h4 class="mb-3">Tambah Metode Pembayaran</h4>

    <form method="POST"
          action="{{ route('admin.payment_methods.store') }}"
          enctype="multipart/form-data">
        @csrf

        {{-- METODE --}}
        <div class="mb-3">
            <label class="form-label">Metode</label>
            <select name="method" class="form-control" required>
                <option value="">-- pilih --</option>
                <option value="bank">Bank</option>
                <option value="ewallet">E-Wallet</option>
                <option value="qris">QRIS</option>
            </select>
        </div>

        {{-- NAMA --}}
        <div class="mb-3">
            <label class="form-label">Nama Bank / Wallet / QRIS</label>
            <input type="text" name="display_name"
                   class="form-control"
                   placeholder="BCA / OVO / DANA / QRIS"
                   required>
        </div>

        {{-- NOMOR --}}
        <div class="mb-3">
            <label class="form-label">Nomor Rekening / Wallet (opsional)</label>
            <input type="text" name="number"
                   class="form-control"
                   placeholder="1234567890">
        </div>

        {{-- UPLOAD --}}
        <div class="mb-3">
            <label class="form-label">Upload Foto (QRIS)</label>
            <input type="file" name="qris_image" class="form-control">
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="active" class="form-check-input" checked>
            <label class="form-check-label">Aktif</label>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.payment_methods.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
