<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
                // WAJIB 1: Membuat semua pilihan instruksi.
            KategoriDisposisiSeeder::class,

                // WAJIB 2: Membuat Jabatan dan Role.
            JabatanSeeder::class,

                // WAJIB 3: Memberi izin umum ke Role.
            PermissionSeeder::class,

                // WAJIB 4: Menghubungkan Role dengan Kategori (membuat "menu").
            KategoriRoleSeeder::class,

                // WAJIB 5: Membuat User dan memberikan Role.
            UserSeeder::class,
        ]);
    }
}
