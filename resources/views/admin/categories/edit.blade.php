@extends('admin.layouts.app')

@section('title', 'Edit Kategori')
@section('page_title', 'Edit Kategori')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Kategori</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@push('styles')
<style>
    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 4px;
    }

    .btn-rounded {
        border-radius: 10px;
        padding: 8px 18px;
        font-weight: 500;
    }

    .btn-gap {
        margin-right: 12px;
    }

    .card-soft {
        border-radius: 18px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 8px 20px rgba(15,23,42,0.03);
    }
</style>
@endpush

@section('content')

    <div class="card card-soft">
        <div class="card-body p-4">

            <h5 class="mb-4" style="font-weight:600;">Edit Kategori</h5>

            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- NAMA KATEGORI --}}
                <div class="form-group mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $category->name) }}"
                           required>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- DESKRIPSI --}}
                <div class="form-group mb-4">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description"
                              rows="3"
                              class="form-control"
                              style="resize:none;">{{ old('description', $category->description) }}</textarea>
                </div>

                {{-- BUTTON Aksi --}}
                <div class="d-flex mt-3">
                    <button class="btn btn-primary btn-rounded btn-gap">Update</button>
                    <a href="{{ route('admin.categories.index') }}"
                       class="btn btn-secondary btn-rounded">Batal</a>
                </div>

            </form>

        </div>
    </div>

@endsection
