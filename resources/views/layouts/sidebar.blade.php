<div class="container-sidebar">
    <div class="sidebar">
        <div class="header">
            <div id="menu-button">
                <input type="checkbox" id="menu-checkbox">
                <label for="menu-checkbox" id="menu-label">
                    <div id="hamburger"></div>
                </label>
            </div>
            <div class="list-item">
                <a href="#">
                    {{-- <img src="gambarsidebar/toko.png" alt=""> --}}
                    <span class="description-header">Toko Zulaikha</span>
                </a>
            </div>
            <div class="illustration">
                <img src="gambarsidebar/illustration.png" alt="">
            </div>
        </div>
        <div class="main">
            <a href="{{ route('dashboard') }}" class="list-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                {{-- <img src="gambarsidebar/dashboard.png" alt="" class="icon"> --}}
                <i class="fas fa-columns text-white me-2"></i>
                <span class="description">Dashboard</span>
            </a>
            @can('is-owner')
                <a href="{{ route('user.index') }}"
                    class="list-item {{ request()->routeIs('user.index') ? 'active' : '' }}">
                    <i class="fas fa-users text-white me-2"></i>
                    <span class="description">Data Pelanggan</span>
                </a>
                <a href="{{ route('produk.index') }}"
                    class="list-item {{ request()->routeIs('produk.*') ? 'active' : '' }}">
                    {{-- <img src="gambarsidebar/dashboard.png" alt="" class="icon"> --}}
                    <i class="fas fa-pizza-slice text-white me-2"></i>
                    <span class="description">Data Produk</span>
                </a>
                <a href="{{ route('kategori.index') }}"
                    class="list-item {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                    <i class="far fa-clipboard text-white me-2"></i>
                    <span class="description">Data Kategori</span>
                </a>
                <a href="{{ route('kasir.index') }}"
                    class="list-item {{ request()->routeIs('kasir.*') ? 'active' : '' }} {{ request()->routeIs('transaction.sukses') ? 'active' : '' }}">
                    <i class="fas fa-cash-register text-white me-2"></i>
                    <span class="description">Kasir</span>
                </a>
                <a href="{{ route('penjualan_online') }}"
                    class="list-item {{ request()->routeIs('laporan_penjualan.*') ? 'active' : '' }} {{ request()->routeIs('cek_penjualan') ? 'active' : '' }} {{ request()->routeIs('penjualan_online') ? 'active' : '' }} {{ request()->routeIs('cek_penjualan_online') ? 'active' : '' }} {{ request()->routeIs('penjualan_offline') ? 'active' : '' }} {{ request()->routeIs('cek_penjualan_offline') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice-dollar text-white me-2"></i>
                    <span class="description">Laporan Penjualan</span>
                </a>
            @endcan
            @can('is-pelanggan')
                <a href="{{ route('riwayat_transaksi.index') }}"
                    class="list-item {{ request()->routeIs('riwayat_transaksi.*') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice text-white me-2"></i>
                    <span class="description">Riwayat Transaksi</span>
                </a>
            @endcan
            <a href="{{ route('profile.index') }}"
                class="list-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                <i class="fas fa-user text-white me-2"></i>
                <span class="description">Profil</span>
            </a>
            <a href="{{ route('logout') }}" class="list-item"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{-- <img src="gambarsidebar/logout.png" alt="" class="icon"> --}}
                <i class="fas fa-sign-out-alt text-white me-2"></i>
                <span class="description ">Logout</span>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>
            </a>
        </div>
    </div>
    <div class="main-content">
        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-light bg-lighten-2 text-black shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        {{-- <main>
            {{ $slot }}
        </main> --}}
        @yield('content')
    </div>
</div>
