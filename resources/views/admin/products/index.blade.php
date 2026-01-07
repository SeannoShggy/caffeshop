@extends('admin.layouts.app')

@section('title', 'Produk')
@section('page_title', 'Produk')


@push('styles')
<style>
    .table-clean thead th {
    background-color: #0f0f1dff !important; /* biru */
    color: white !important;              /* teks putih */
   
}
    .page-header-title { font-size: 1.3rem; font-weight: 600; color: #111827; }
    .page-header-sub { font-size: 0.9rem; color: #6b7280; }

    .card-soft { border-radius: 18px; border: 1px solid #e5e7eb; box-shadow: 0 8px 20px rgba(15,23,42,0.03); }
    .card-soft .card-body { padding: 0; }

    .table-clean th, .table-clean td {
        border: none!important;
        padding: 12px 20px;
        font-size: .9rem;
        vertical-align: middle;
    }
    .table-clean thead tr { border-bottom: 1px solid #e5e7eb; }
    .table-clean tbody tr + tr { border-top: 1px solid #f3f4f6; }

    .btn-add-product { border-radius: 999px; padding: 6px 14px; font-weight: 500; }

    /* Tombol aksi hanya ikon */
.action-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 14px;
    border: none;
    cursor: pointer;
}

/* Edit = biru soft */
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

/* Wrapper agar sejajar kiri dan kanan */
.action-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
}

    .stock-pill { padding: 4px 12px; border-radius: 999px; font-size: .8rem; }
    .stock-green { background:#dcfce7; color:#166534; }
    .stock-yellow { background:#fef3c7; color:#92400e; }
    .stock-red { background:#fee2e2; color:#b91c1c; }

    .modal-content { border-radius: 18px; }
</style>
@endpush

@section('content')

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <div class="page-header-title">Produk</div>
            <div class="page-header-sub">Kelola produk caffeshop Anda</div>
        </div>

        <button class="btn btn-dark btn-add-product" data-toggle="modal" data-target="#modal-create">
            <i class="fas fa-plus mr-1"></i> Tambah Produk
        </button>
    </div>

   
    {{-- TABLE --}}
    <div class="card card-soft">
        <div class="card-body">
            <table class="table table-clean mb-0">
                <thead>
                <tr>
                    <th width="60">No</th>
                    <th width="80">Foto</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th width="140">Harga</th>
                    <th width="170">Aksi</th>
                </tr>
                </thead>

                <tbody>
                @forelse($products as $index => $product)

                   

                    <tr>
                        <td>{{ $index + 1 }}</td>

                        {{-- FOTO --}}
                        <td>
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}"
                                    width="50" height="50"
                                    style="border-radius:8px; object-fit:cover;">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        {{-- DETAIL --}}
                        <td>
                            <div class="font-weight-500">{{ $product->name }}</div>
                            <div style="font-size:.8rem; color:#6b7280;">
                                {{ $product->description ?? '' }}
                            </div>
                        </td>

                        <td>{{ $product->category ?? '-' }}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>

                        

                        {{-- ACTION --}}
                        <td>
    <div class="action-wrapper">

        {{-- EDIT --}}
        <button
            class="action-btn action-edit btn-edit-product"
            data-toggle="modal"
            data-target="#modal-edit"
            data-id="{{ $product->id }}"
            data-name="{{ $product->name }}"
            data-category="{{ $product->category }}"
            data-price="{{ $product->price }}"
            data-stock="{{ $product->stock }}"
            data-description="{{ $product->description }}"
        >
            <i class="fas fa-edit"></i>
        </button>

        {{-- DELETE --}}
        <form action="{{ route('admin.products.destroy', $product) }}"
              method="POST"
              onsubmit="return confirm('Yakin hapus produk ini?')">
            @csrf
            @method('DELETE')
            <button class="action-btn action-delete">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>

    </div>
</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Belum ada produk.
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
    </div>

    {{-- MODAL TAMBAH PRODUK --}}
    <div class="modal fade" id="modal-create">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Produk</h5>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="category" class="form-control">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <label>Harga</label>
                                <input type="number" name="price" class="form-control" required>
                            </div>
                            
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Foto Produk</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT PRODUK --}}
    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form id="form-edit" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Produk</h5>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" id="edit-id">

                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" name="name" id="edit-name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="category" id="edit-category" class="form-control">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <label>Harga</label>
                                <input type="number" name="price" id="edit-price" class="form-control" required>
                            </div>
                            
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="description" id="edit-description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Foto Baru (optional)</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Update</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    $(function () {
        $('.btn-edit-product').on('click', function () {

            let btn = $(this);

            let id = btn.data('id');
            $('#form-edit').attr('action', "{{ url('admin/products') }}/" + id);

            // nama
            $('#edit-name').val(btn.data('name'));

            // kategori
            $('#edit-category').val(btn.data('category'));

            // harga → ubah dari 18000.00 menjadi 18000
            let price = btn.data('price');
            price = parseInt(price);
            $('#edit-price').val(price);

            // deskripsi
            $('#edit-description').val(btn.data('description'));
        });
    });
</script>
@endpush

