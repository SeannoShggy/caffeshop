<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}"
             class="brand-image img-circle elevation-3"
             style="opacity:.8">
        <span class="brand-text font-weight-light">Caffeshop Admin</span>
    </a>

    <div class="sidebar">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">

                {{-- DASHBOARD --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- KATEGORI --}}
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}"
                       class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <p>Kategori</p>
                    </a>
                </li>

                {{-- PRODUK --}}
                <li class="nav-item">
                    <a href="{{ route('admin.products.index') }}"
                       class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-beer"></i>

                        <p>Produk</p>
                    </a>
                </li>

                {{-- STOK --}}
                <li class="nav-item">
                    <a href="{{ route('admin.stock.index') }}"
                       class="nav-link {{ request()->routeIs('admin.stock.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>Manajemen Stok</p>
                    </a>
                </li>
                {{-- METODE PEMBAYARAN --}}
<li class="nav-item">
    <a href="{{ route('admin.payment_methods.index') }}"
       class="nav-link {{ request()->routeIs('admin.payment_methods.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-money-check-alt"></i>
        <p>Metode Pembayaran</p>
    </a>
</li>

{{-- pesanan --}}
                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}"
                       class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p>Pesanan</p>
                    </a>
                </li>
                {{-- TRANSAKSI --}}
                <li class="nav-item">
                    <a href="{{ route('admin.transactions.index') }}"
                       class="nav-link {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-receipt"></i>
                        <p>Transaksi</p>
                    </a>
                </li>
                

                {{-- PENGGUNA (ADMIN SAJA) --}}
                @if(auth()->user()->isAdmin())
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}"
                       class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>Pengguna</p>
                    </a>
                </li>
                @endif

             

                {{-- LOGOUT --}}
                <li class="nav-item">
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="button"
                                class="nav-link btn btn-link text-left text-white"
                                onclick="confirmLogout()">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </button>
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>

@push('scripts')
<script>
function confirmLogout() {
    if (confirm('Apakah Anda yakin ingin keluar?')) {
        document.getElementById('logout-form').submit();
    }
}
</script>
@endpush

<style>
    .main-sidebar {
    background-color: #0f0f1dff !important; /* ganti dengan warna yang kamu mau */
}
/* Ubah warna teks menu */
.main-sidebar .nav-link {
    color: #ffffffff !important;
}

.main-sidebar .nav-link:hover {
    background-color: #007bff !important;
    color: #ffffff !important;
}
    .nav-sidebar .nav-link.active {
    background-color: #007bff !important;  /* biru */
    color: #000000ff !important;             /* teks putih */
}

.nav-sidebar .nav-link.active i {
    color: #000000ff !important;             /* icon putih */
}

</style>
<script>
function confirmLogout() {
    if (confirm('Yakin mau logout?')) {
        document.getElementById('logout-form').submit();
    }
}
</script>
