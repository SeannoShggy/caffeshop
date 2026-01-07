@extends('admin.layouts.app')

@section('title', 'Pengguna')
@section('page_title', 'Pengguna')

@push('styles')
<style>
    .table-clean thead th {
        background-color: #0f0f1dff !important; /* biru gelap */
        color: white !important;               /* teks putih */
    }

    .page-header-title { font-size:1.3rem; font-weight:600; color:#111827; }
    .page-header-sub { font-size:.9rem; color:#6b7280; }

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

    .btn-add-user { border-radius:999px; padding:6px 14px; font-weight:500; }
    .badge-role { border-radius:999px; padding:4px 10px; font-size:.8rem; }

    /* ACTION ICON BUTTONS */
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
        align-items: center;
        gap: 8px;
    }
</style>
@endpush

@section('content')

    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <div class="page-header-title">Pengguna</div>
            <div class="page-header-sub">Kelola akun admin & kasir</div>
        </div>

        <button class="btn btn-dark btn-add-user" data-toggle="modal" data-target="#modal-create">
            <i class="fas fa-plus mr-1"></i> Tambah Pengguna
        </button>
    </div>

  
    <div class="card card-soft">
        <div class="card-body">
            <table class="table table-clean mb-0">
                <thead>
                <tr>
                    <th width="60">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th width="120">Role</th>
                    <th width="180">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge badge-role badge-primary">Admin</span>
                            @else
                                <span class="badge badge-role badge-secondary">User</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-wrapper">
                                {{-- EDIT --}}
                                <button
                                    class="action-btn action-edit btn-edit-user"
                                    data-toggle="modal"
                                    data-target="#modal-edit"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    data-email="{{ $user->email }}"
                                    data-role="{{ $user->role }}"
                                >
                                    <i class="fas fa-edit"></i>
                                </button>

                                {{-- HAPUS (tidak bisa hapus diri sendiri) --}}
                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin hapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="action-btn action-delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Belum ada pengguna.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL TAMBAH --}}
    <div class="modal fade" id="modal-create">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pengguna</h5>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                            <small class="text-muted">Minimal 8 karakter.</small>
                        </div>

                        <div class="form-group">
                            <label>Role</label>
                            <select name="role" class="form-control" required>
                                <option value="admin">Admin (Pemilik)</option>
                                <option value="user">User (Kasir)</option>
                            </select>
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

    {{-- MODAL EDIT --}}
    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="form-edit" method="POST">
                    @csrf @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Pengguna</h5>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" id="edit-name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" id="edit-email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Role</label>
                            <select name="role" id="edit-role" class="form-control" required>
                                <option value="admin">Admin (Pemilik)</option>
                                <option value="user">User (Kasir)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Password Baru (opsional)</label>
                            <input type="password" name="password" class="form-control">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
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
        $('.btn-edit-user').on('click', function () {
            const btn   = $(this);
            const id    = btn.data('id');
            const name  = btn.data('name');
            const email = btn.data('email');
            const role  = btn.data('role');

            const url = "{{ url('admin/users') }}/" + id;
            $('#form-edit').attr('action', url);

            $('#edit-name').val(name);
            $('#edit-email').val(email);
            $('#edit-role').val(role);
        });
    });
</script>
@endpush
