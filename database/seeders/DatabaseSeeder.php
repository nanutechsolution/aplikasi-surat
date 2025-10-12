<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Kosongkan notifikasi dulu (opsional)
        DB::table('notifications')->truncate();

        // Jalankan seeder Role dan Kategori Disposisi
        $this->call([
            RolePermissionSeeder::class,
            KategoriDisposisiSeeder::class,
        ]);

        // ===========================
        // 📌 USER ADMIN
        // ===========================
        $admin = User::factory()->create([
            'name' => 'Admin Sistem',
            'email' => 'admin@example.com',
        ]);
        $admin->assignRole('admin');

        // ===========================
        // 📌 USER DIREKTUR
        // ===========================
        $direktur = User::factory()->create([
            'name' => 'Direktur Utama',
            'email' => 'direktur@example.com',
        ]);
        $direktur->assignRole('direktur');

        // ===========================
        // 📌 USER KA
        // ===========================
        $ka = User::factory()->create([
            'name' => 'Kepala Akademik',
            'email' => 'ka@example.com',
        ]);
        $ka->assignRole('ka');

        // ===========================
        // 📌 USER WAKA
        // ===========================
        $waka = User::factory()->create([
            'name' => 'Wakil Kepala',
            'email' => 'waka@example.com',
        ]);
        $waka->assignRole('waka');

        // // ===========================
        // // 📌 USER STAF
        // // ===========================
        // $stafUsers = User::factory()->count(3)->create();
        // foreach ($stafUsers as $i => $staf) {
        //     $staf->update(['name' => "Staf Bagian " . ($i + 1)]);
        //     $staf->assignRole('staf');
        // }
    }
}
