# Batik Livewire

Platform e-commerce modern untuk penjualan produk batik yang dibangun dengan Laravel Livewire. Aplikasi ini menyediakan sistem manajemen lengkap untuk produk, pesanan, pengguna, dan artikel dengan antarmuka yang interaktif dan responsif.

## Deskripsi Singkat

Batik Livewire adalah aplikasi e-commerce yang dirancang khusus untuk memudahkan penjualan produk batik secara online. Dilengkapi dengan panel admin komprehensif dan antarmuka pelanggan yang user-friendly untuk pengalaman berbelanja yang optimal.

## Fitur Utama

### Untuk Pelanggan

-   Katalog produk dengan pencarian dan filter
-   Keranjang belanja interaktif
-   Checkout dan pembayaran via Midtrans
-   Riwayat dan tracking pesanan
-   Manajemen profil dan alamat
-   Akses artikel

### Untuk Admin

-   Dashboard dengan analytics penjualan
-   Manajemen produk, kategori, dan stok
-   Manajemen pesanan dan status pengiriman
-   Manajemen pengguna
-   Manajemen artikel dan koten
-   Profil administrator

### Keamanan

-   Autentikasi dan otorisasi role-based
-   Middleware protection untuk route admin

## Teknologi yang Digunakan

-   **Laravel Herd 12** - PHP development environment
-   **Livewire 3.6** - Full-stack framework untuk komponen interaktif
-   **Tailwind CSS (CDN)** - Utility-first CSS framework
-   **SweetAlert2** - Beautiful, responsive alerts
-   **Midtrans** - Payment gateway integration
-   **MySQL** - Database management system

## Cara Instalasi

### Prasyarat

Pastikan sistem telah terinstall:

-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   MySQL atau SQLite
-   Git

### Langkah Instalasi

1. **Clone Repository**

    ```bash
    git clone <repository-url>
    cd batik_livewire
    ```

2. **Install Dependencies PHP**

    ```bash
    composer install
    ```

3. **Install Dependencies JavaScript**

    ```bash
    npm install
    ```

4. **Konfigurasi Environment**

    ```bash
    # Copy file .env.example menjadi .env
    cp .env.example .env

    # Generate application key
    php artisan key:generate
    ```

5. **Konfigurasi Database**

    Edit file `.env` dan sesuaikan konfigurasi database:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=batik_livewire
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6. **Jalankan Migrasi Database**

    ```bash
    php artisan migrate
    ```

7. **Seed Database (Opsional)**

    ```bash
    php artisan db:seed
    ```

8. **Buat Storage Link**

    ```bash
    php artisan storage:link
    ```

9. **Build Assets**
    ```bash
    npm run build
    ```

## Cara Menjalankan Project

### Metode 1: Development Mode (Recommended)

Buka Sites lalu cari nama project "batik_livewire" yang terdapat pada halaman Sites lalu cari URL "http://batik_livewire.test" dan buka URL tersebut.

## Akses Aplikasi

Setelah server berjalan, akses aplikasi melalui browser:

-   **Frontend**: `http://batik_livewire.test`
-   **Admin Panel**: `http://batik_livewire.test/admin/dashboard`

## Struktur Project

```
batik_livewire/
├── app/
│   ├── Livewire/          # Komponen Livewire
│   │   ├── Admin/         # Komponen admin panel
│   │   ├── Auth/          # Komponen autentikasi
│   │   └── User/          # Komponen user
│   ├── Models/            # Eloquent models
│   └── Http/              # Controllers & Middleware
├── database/
│   ├── migrations/        # Database migrations
│   └── seeders/           # Database seeders
├── resources/
│   ├── views/             # Blade templates
│   │   └── livewire/      # Livewire views
│   └── css/               # Stylesheets
├── routes/
│   └── web.php            # Route definitions
└── public/                # Public assets
```

## Konfigurasi Tambahan

### Midtrans Payment Gateway

Untuk mengaktifkan payment gateway, tambahkan konfigurasi Midtrans di file `.env`:

```env
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false
```
