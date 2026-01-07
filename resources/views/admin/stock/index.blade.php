@extends('admin.layouts.app')

@section('title', 'Manajemen Stok')
@section('page_title', 'Manajemen Stok')

@push('styles')
<style>
    .table-clean thead th {
        background-color: #0f0f1dff !important;
        color: white !important;
    }

    .page-header-title { font-size: 1.3rem; font-weight: 600; color:#111827; }
    .page-header-sub { font-size: .9rem; color:#6b7280; }

    .card-soft { border-radius:18px; border:1px solid #e5e7eb; box-shadow:0 8px 20px rgba(15,23,42,0.03); }
    .card-soft .card-body { padding:0; }

    .table-clean th, .table-clean td {
        border:none!important;
        padding:12px 20px;
        font-size:.9rem;
        vertical-align:middle;
    }

    .table-clean thead tr { border-bottom:1px solid #e5e7eb; }
    .table-clean tbody tr + tr { border-top:1px solid #f3f4f6; }

    .stock-input {
        width: 80px;
    }

    /* Tombol Update pindah ke kolom AKSI */
    .btn-update-stock {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: .85rem;
        font-weight: 500;
    }
</style>
@endpush

@section('content')

    <div class="mb-3">
        <div class="page-header-title">Manajemen Stok</div>
        <div class="page-header-sub">
            Atur stok produk caffeshop Anda
        </div>
    </div>

  

    <div class="card card-soft">
        <div class="card-body">
            <table class="table table-clean mb-0">
                <thead>
                <tr>
                    <th style="width:60px;">No</th>
                    <th>Produk</th>
                    <th style="width:120px;">Stok</th>
                    <th style="width:120px;">Aksi</th>
                </tr>
                </thead>

                <tbody>
                @forelse($products as $index => $product)

                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td>
                            <div class="font-weight-500">{{ $product->name }}</div>
                            @if($product->category)
                                <div style="font-size:.8rem; color:#6b7280;">
                                    {{ $product->category }}
                                </div>
                            @endif
                        </td>

                        {{-- INPUT STOK --}}
                        <td>
                            <input type="number"
                                form="update-form-{{ $product->id }}"
                                name="stock"
                                class="form-control form-control-sm stock-input"
                                value="{{ $product->stock }}"
                                min="0">
                        </td>

                        {{-- TOMBOL UPDATE DI KOlOM AKSI --}}
                        <td>
                            <form id="update-form-{{ $product->id }}"
                                  action="{{ route('admin.stock.update', $product->id) }}"
                                  method="POST">
                                @csrf
                                @method('PUT')

                                <button type="submit" class="btn-update-stock">
                                    Update
                                </button>
                            </form>
                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            Belum ada produk.
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
    </div>

@endsection
