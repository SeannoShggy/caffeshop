<title>@yield('title','Pembayaran') | Caffeshop Admin</title>
<link rel="icon" type="image/png" href="{{ asset('logo seanspace.png') }}">
@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Metode Pembayaran</h4>
        <a href="{{ route('admin.payment_methods.create') }}" class="btn btn-primary">Tambah</a>
    </div>

  

    <table class="table table-bordered align-middle">
        <thead class="table">
            <tr>
                <th>No</th>
                <th>Metode</th>
                <th>Nama</th>
                <th>Nomor</th>
                <th>Foto / QR</th>
                <th>Active</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($methods as $m)
            @php
                $details = $m->details ?? [];
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>

                {{-- METODE --}}
                <td class="text-uppercase">
                    {{ $details['method'] ?? $m->type }}
                </td>

                {{-- NAMA --}}
                <td>
                    {{ $details['name'] ?? $m->name }}
                </td>

                {{-- NOMOR --}}
                <td>
                    {{ $details['number'] ?? '-' }}
                </td>

                {{-- FOTO / QR --}}
                <td>
                    @if(!empty($details['qrcode_url']))
                        <img src="{{ $details['qrcode_url'] }}"
                             alt="QR"
                             style="max-width:80px;border-radius:6px;">
                    @else
                        -
                    @endif
                </td>

                {{-- ACTIVE --}}
                <td>
                    @if($m->active)
                        <span class="badge bg-success">Ya</span>
                    @else
                        <span class="badge bg-secondary">Tidak</span>
                    @endif
                </td>

                {{-- AKSI --}}
                <td>
                    <a href="{{ route('admin.payment_methods.edit', $m) }}"
                       class="btn btn-sm btn-outline-primary">
                        Edit
                    </a>

                    <form action="{{ route('admin.payment_methods.destroy', $m) }}"
                          method="POST"
                          style="display:inline"
                          onsubmit="return confirm('Hapus?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-muted">
                    Belum ada metode pembayaran
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
