<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mazer Admin Dashboard</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dist/assets/css/bootstrap.css') }}">

    <link rel="stylesheet" href="{{ asset('dist/assets/vendors/iconly/bold.css') }}">

    <link rel="stylesheet" href="{{ asset('dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/css/app.css') }}">

    <!-- CSS untuk memperbaiki layout vertikal di halaman pendek (Masalah Pagination) -->
    <style>
        #main {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Paksa tinggi #main minimal setinggi layar */
        }
        .page-content {
            flex-grow: 1; /* Paksa .page-content mengisi sisa ruang */
        }
        footer {
            margin-top: auto; /* Paksa footer berada di bagian bawah */
        }
    </style>

    @livewireStyles

</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo">
                            <a href="{{ route('admin.dashboard') }}"><img src="{{ asset('images/logo.png') }}" class="" alt="Logo" srcset="">Batik Urang</a>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">MENU UTAMA</li>

        <li class="sidebar-item {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class='sidebar-link'>
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- [PENAMBAHAN BARU] Tautan ke Halaman Utama (Welcome) -->
        <li class="sidebar-item">
            <a href="{{ route('welcome') }}" class='sidebar-link' target="_blank">
                <i class="bi bi-house-door-fill"></i>
                <span>Lihat Website</span>
            </a>
        </li>
        <!-- [AKHIR PENAMBAHAN] -->


        <li class="sidebar-title">MANAJEMEN E-COMMERCE</li>

        <li class="sidebar-item {{ Request::routeIs('admin.orders') ? 'active' : '' }}">
            <a href="{{ route('admin.orders') }}" class='sidebar-link'>
                <i class="bi bi-bag-check-fill"></i>
                <span>Manajemen Pesanan</span>
            </a>
        </li>

        <!-- Ikon Produk (FIXED) -->
        <li class="sidebar-item {{ Request::routeIs('admin.products') ? 'active' : '' }}">
            <a href="{{ route('admin.products') }}" class='sidebar-link'>
                <i class="bi bi-grid-fill"></i> <!-- Menggunakan ikon yang terbukti berfungsi -->
                <span>Manajemen Produk</span>
            </a>
        </li>

        <li class="sidebar-item {{ Request::routeIs('admin.categories') ? 'active' : '' }}">
            <a href="{{ route('admin.categories') }}" class='sidebar-link'>
                <i class="bi bi-tags-fill"></i>
                <span>Manajemen Kategori</span>
            </a>
        </li>

        <li class="sidebar-item {{ Request::routeIs('admin.articles') ? 'active' : '' }}">
            <a href="{{ route('admin.articles') }}" class='sidebar-link'>
                <i class="bi bi-journal-text"></i>
                <span>Manajemen Artikel</span>
            </a>
        </li>

        <li class="sidebar-item {{ Request::routeIs('admin.users') ? 'active' : '' }}">
            <a href="{{ route('admin.users') }}" class='sidebar-link'>
                <i class="bi bi-people-fill"></i>
                <span>Manajemen Pengguna</span>
            </a>
        </li>


        <li class="sidebar-title">PENGATURAN</li>
        
        <li class="sidebar-item {{ Request::routeIs('admin.profile') ?'active' : '' }}">
            <a href="{{ route('admin.profile') }}" class='sidebar-link'>
                <i class="bi bi-gear-fill"></i>
                <span>Akun Saya</span>
            </a>
        </li>
        
        <li class="sidebar-item">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class='sidebar-link'>
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
        </li>
        
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>

    </ul>
</div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-content">
                {{ $slot }}
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2025 &copy; Batik Urang</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                                href="https://portofolio.hanifun.my.id">Hanifun</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('dist/assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('dist/assets/vendors/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('dist/assets/js/main.js') }}"></script>
    
    @livewireScripts
@stack('scripts')
<script>
    // Listener untuk notifikasi sukses (Toast)
    Livewire.on('success-alert', (event) => {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "success",
            title: "Berhasil"
        });
    });

    // LISTENER HAPUS (KONFIRMASI SWEETALERT)
    Livewire.on('show-delete-confirmation', (event) => {
        Swal.fire({
            title: "Apakah Anda Yakin?",
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim event kembali ke Livewire untuk menjalankan hapus
                Livewire.dispatch('delete-confirmed');
            }
        });
    });
</script>
</body>

</html>