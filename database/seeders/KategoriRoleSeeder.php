<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role; // Pastikan menggunakan model Role custom Anda
use App\Models\KategoriDisposisi;

class KategoriRoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Temukan Roles yang sudah ada
        $roleAdmin = Role::findByName('admin'); // Ambil role admin
        $roleDirektur = Role::findByName('direktur');
        $roleManajer = Role::findByName('manajer');
        $roleStaf = Role::findByName('staf');

        // 2. Ambil semua ID kategori instruksi
        $semuaInstruksiIds = KategoriDisposisi::pluck('id');

        // 3. Berikan semua instruksi kepada Admin dan Direktur
        if ($roleAdmin) {
            $roleAdmin->kategoriDisposisi()->sync($semuaInstruksiIds); // Gunakan sync untuk keamanan
        }
        if ($roleDirektur) {
            $roleDirektur->kategoriDisposisi()->sync($semuaInstruksiIds);
        }

        // 4. Berikan instruksi spesifik untuk Manajer
        if ($roleManajer) {
            $instruksiManajerIds = KategoriDisposisi::whereIn('nama', [
                'Koordinasikan',
                'Monitor',
                'Laporkan Hasil',
                'Jadwalkan',
                'Tindaklanjuti',
                'Selesaikan'
            ])->pluck('id');
            $roleManajer->kategoriDisposisi()->sync($instruksiManajerIds);
        }

        // 5. Berikan instruksi minimal untuk Staf
        if ($roleStaf) {
            $instruksiStafIds = KategoriDisposisi::whereIn('nama', ['Arsip', 'Copy'])->pluck('id');
            $roleStaf->kategoriDisposisi()->sync($instruksiStafIds);
        }
    }
}
