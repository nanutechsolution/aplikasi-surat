<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // --- PENGGUNA LEVEL TERTINGGI / DI LUAR STRUKTUR ---

        // Buat User Admin Sistem
        $admin = User::create([
            'name' => 'Admin Sistem',
            'email' => 'admin@example.com',
            'password' => Hash::make('Password123'),
            'jabatan_id' => Jabatan::where('nama', 'Admin Sistem')->firstOrFail()->id,
            'manager_id' => null, // Admin tidak punya atasan
        ]);
        $admin->assignRole('admin');

        // Buat User Direktur
        $direktur = User::create([
            'name' => 'Direktur Utama',
            'email' => 'direktur@example.com',
            'password' => Hash::make('password'),
            'jabatan_id' => Jabatan::where('nama', 'Direktur')->firstOrFail()->id,
            'manager_id' => null, // Direktur adalah puncak hierarki
        ]);
        $direktur->assignRole('direktur');

        // --- PENGGUNA STRUKTURAL (BAWAHAN DIREKTUR) ---

        $bawahanDirektur = [
            'KASUBDIT 24.1' => ['name' => 'Kepala Subdirektorat 24.1', 'email' => 'kasubdit241@example.com', 'role' => 'kasubdit'],
            'KASUBDIT 24.2' => ['name' => 'Kepala Subdirektorat 24.2', 'email' => 'kasubdit242@example.com', 'role' => 'kasubdit'],
            'KASUBDIT 24.3' => ['name' => 'Kepala Subdirektorat 24.3', 'email' => 'kasubdit243@example.com', 'role' => 'kasubdit'],
            'KASUBDIT 24.4' => ['name' => 'Kepala Subdirektorat 24.4', 'email' => 'kasubdit244@example.com', 'role' => 'kasubdit'],
            'TIM ANEV' => ['name' => 'Tim Analisa & Evaluasi', 'email' => 'timanev@example.com', 'role' => 'tim'],
            'TIM MONEV' => ['name' => 'Tim Monitoring & Evaluasi', 'email' => 'timmonev@example.com', 'role' => 'tim'],
            'KOORD. TIM ANEV DE II' => ['name' => 'Koordinator Tim Anev DE II', 'email' => 'koord.anev@example.com', 'role' => 'koordinator'],
            'TATA USAHA' => ['name' => 'Kepala Tata Usaha', 'email' => 'tu@example.com', 'role' => 'tata-usaha'],
        ];

        foreach ($bawahanDirektur as $jabatanNama => $detailUser) {
            $user = User::create([
                'name' => $detailUser['name'],
                'email' => $detailUser['email'],
                'password' => Hash::make('password'),
                'jabatan_id' => Jabatan::where('nama', $jabatanNama)->firstOrFail()->id,
                'manager_id' => $direktur->id, // Atasan mereka semua adalah Direktur
            ]);
            $user->assignRole($detailUser['role']);
        }
    }
}

