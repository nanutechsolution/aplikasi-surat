<?php

use App\Livewire\DashboardStatistik;
use App\Livewire\Disposisi\RiwayatDisposisi;
use App\Livewire\DisposisiMasuk;
use App\Livewire\EditSurat;
use App\Livewire\KelolaPengguna;
use App\Livewire\KelolaSuratKeluar;
use App\Livewire\KelolaSuratMasuk;
use App\Livewire\LaporanSurat;
use App\Livewire\LihatSurat;
use App\Livewire\LogAktivitas;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});
// Dashboard bisa diakses semua yang sudah login
Route::get('dashboard', DashboardStatistik::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Halaman Surat Masuk: hanya bisa diakses oleh admin dan direktur
Route::get('surat-masuk', KelolaSuratMasuk::class)
    ->middleware(['auth', 'role:admin|direktur'])
    ->name('surat-masuk');

// Halaman Detail Surat: juga hanya untuk admin dan direktur
Route::get('surat-masuk/{surat:uuid}', LihatSurat::class)
    ->middleware(['auth', 'can:view,surat'])
    ->name('surat.lihat');

// Halaman Edit Surat: juga hanya untuk admin dan direktur
Route::get('surat-masuk/{surat:uuid}/edit', EditSurat::class)
    ->middleware(['auth', 'role:admin|direktur'])
    ->name('surat.edit');

// Halaman Disposisi Masuk: bisa diakses semua yang sudah login
Route::get('disposisi-masuk', DisposisiMasuk::class)
    ->middleware(['auth'])
    ->name('disposisi.masuk');
Route::get('pengguna', KelolaPengguna::class)
    ->middleware(['auth', 'role:admin'])
    ->name('pengguna');
// Halaman Profile: bisa diakses semua yang sudah login
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('surat-keluar', KelolaSuratKeluar::class)
    ->middleware(['auth', 'permission:kelola surat keluar'])
    ->name('surat-keluar');

Route::get('laporan', LaporanSurat::class)
    ->middleware(['auth', 'role:admin|direktur'])
    ->name('laporan');

Route::get('log-aktivitas', LogAktivitas::class)
    ->middleware(['auth', 'role:admin'])
    ->name('log.aktivitas');

Route::get('disposisi/riwayat', RiwayatDisposisi::class)
    ->middleware(['auth', 'role:admin'])
    ->name(name: 'disposisi.riwayat');
require __DIR__ . '/auth.php';
