<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jabatan;
use App\Models\Role; // Pastikan menggunakan model Role custom Anda

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Jabatan & Role yang akan dibuat
        $jabatanRoles = [
            'Admin Sistem' => 'admin',
            'Direktur' => 'direktur',
            'Manajer' => 'manajer',
            'Staf' => 'staf',
            'KASUBDIT 24.1' => 'kasubdit',
            'KASUBDIT 24.2' => 'kasubdit',
            'KASUBDIT 24.3' => 'kasubdit',
            'KASUBDIT 24.4' => 'kasubdit',
            'TIM ANEV' => 'tim',
            'TIM MONEV' => 'tim',
            'KOORD. TIM ANEV DE II' => 'koordinator',
            'TATA USAHA' => 'tata-usaha',
        ];

        foreach ($jabatanRoles as $jabatan => $role) {
            // Buat Jabatan
            Jabatan::firstOrCreate(['nama' => $jabatan]);

            // Buat Role jika belum ada
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
