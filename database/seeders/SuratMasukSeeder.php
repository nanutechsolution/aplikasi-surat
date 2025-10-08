<?php

namespace Database\Seeders;

use App\Models\SuratMasuk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuratMasukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama agar tidak duplikat setiap kali seeding
        SuratMasuk::truncate();

        // Buat 50 data surat masuk palsu menggunakan factory
        SuratMasuk::factory()->count(50)->create();
    }
}
