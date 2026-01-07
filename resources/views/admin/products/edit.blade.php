@extends('admin.layouts.app')

@section('content')
    <h1 class="mb-4">Edit Produk</h1>

    <form action="{{ route('admin.products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <input type="text" name="category" class="form-control"
                   value="{{ old('category', $product->category) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="price" class="form-control"
                   value="{{ old('price', $product->price) }}" required>
        </div>

       

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3">
                {{ old('description', $product->description) }}
            </textarea>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection
