@extends('admin.layouts.app')

@section('title', 'Edit Metode Pembayaran')
@section('page_title', 'Edit Metode Pembayaran')

@section('content')
<div class="container" style="max-width:700px">
    <div class="card">
        <div class="card-header">
            <strong>Edit Metode Pembayaran</strong>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.payment_methods.update', $method) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @php
                    $details = $method->details ?? [];
                @endphp

                {{-- METODE --}}
                <div class="mb-3">
                    <label class="form-label">Metode</label>
                    <select name="method" class="form-control" required>
                        <option value="bank" {{ ($details['method'] ?? '')=='bank' ? 'selected' : '' }}>Bank</option>
                        <option value="ewallet" {{ ($details['method'] ?? '')=='ewallet' ? 'selected' : '' }}>E-Wallet</option>
                        <option value="qris" {{ ($details['method'] ?? '')=='qris' ? 'selected' : '' }}>QRIS</option>
                    </select>
                </div>

                {{-- NAMA --}}
                <div class="mb-3">
                    <label class="form-label">Nama Bank / Wallet / QRIS</label>
                    <input type="text"
                           name="display_name"
                           class="form-control"
                           value="{{ old('display_name', $details['name'] ?? $method->name) }}"
                           required>
                </div>

                {{-- NOMOR --}}
                <div class="mb-3">
                    <label class="form-label">Nomor Rekening / Wallet (opsional)</label>
                    <input type="text"
                           name="number"
                           class="form-control"
                           value="{{ old('number', $details['number'] ?? '') }}">
                </div>

                {{-- QR --}}
                <div class="mb-3">
                    <label class="form-label">Upload QR (QRIS)</label>
                    <input type="file" name="qris_image" class="form-control">
                </div>

                {{-- PREVIEW QR --}}
                @if(!empty($details['qrcode_url']))
                    <div class="mb-3">
                        <label class="form-label">QR Saat Ini</label><br>
                        <img src="{{ $details['qrcode_url'] }}"
                             style="max-width:150px;border-radius:8px">
                    </div>
                @endif

                {{-- ACTIVE --}}
                <div class="form-check mb-3">
                    <input type="checkbox"
                           name="active"
                           class="form-check-input"
                           id="active"
                           {{ $method->active ? 'checked' : '' }}>
                    <label for="active" class="form-check-label">Aktif</label>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.payment_methods.index') }}"
                       class="btn btn-outline-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
