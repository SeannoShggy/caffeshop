@extends('admin.layouts.app')

@section('title', 'Kategori')
@section('page_title', 'Kategori')



@push('styles')
<style>

    .table-clean thead th {
    background-color: #0f0f1dff !important; /* biru */
    color: white !important;              /* teks putih */
   
}

    .page-header-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #111827;
    }
    .page-header-sub {
        font-size: 0.9rem;
        color: #6b7280;
    }
    .card-soft {
        border-radius: 18px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 8px 20px rgba(15,23,42,0.03);
    }
    .card-soft .card-body {
        padding: 0;
    }
    .table-clean th,
    .table-clean td {
        border: none !important;
        padding: 12px 20px;
        font-size: 0.9rem;
    }
    .table-clean thead tr {
        border-bottom: 1px solid #e5e7eb;
    }
    .table-clean tbody tr + tr {
        border-top: 1px solid #f3f4f6;
    }
    
    .btn-add-category {
        border-radius: 999px;
        padding: 6px 14px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .action-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 14px;
    border: none;
}

.action-edit {
    background: #ffffffff;
    color: #007bff;
    border: 1px solid #bfdbfe;
}

.action-delete {
    background: #ffffffff;
    color: #007bff;
    border: 1px solid #bfdbfe;
}

.action-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
}

</style>
@endpush

@section('content')

    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <div class="page-header-title">Kategori</div>
            <div class="page-header-sub">
                Kelola kategori produk caffeshop Anda
            </div>
        </div>

        <a href="{{ route('admin.categories.create') }}" class="btn btn-dark btn-add-category">
            <i class="fas fa-plus mr-1"></i> Tambah Kategori
        </a>
    </div>

   

    <div class="card card-soft">
        <div class="card-body">
            <table class="table table-clean mb-0">
                <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th style="width: 160px;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($categories as $index => $category)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description ?? '-' }}</td>
                        <td>
    <div class="action-wrapper">
        <a href="{{ route('admin.categories.edit', $category) }}"
           class="action-btn action-edit">
            <i class="fas fa-edit"></i>
        </a>

        <form action="{{ route('admin.categories.destroy', $category) }}"
              method="POST"
              onsubmit="return confirm('Yakin hapus kategori ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="action-btn action-delete">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    </div>
</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            Belum ada kategori.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
