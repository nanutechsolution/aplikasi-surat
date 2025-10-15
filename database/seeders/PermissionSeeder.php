<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. BUAT DAFTAR PERMISSIONS (IZIN)
        Permission::create(['name' => 'kelola surat']);      // Bisa membuat, edit, hapus surat
        Permission::create(['name' => 'buat disposisi']);   // Bisa membuat disposisi
        Permission::create(['name' => 'lihat semua surat']); // Bisa melihat semua surat, tidak hanya miliknya
        Permission::create(['name' => 'kelola pengguna']);   // Bisa CRUD user
        Permission::create(['name' => 'kelola jabatan dan role']); // Bisa mengatur hak akses

        // 2. TEMUKAN ROLES YANG SUDAH DIBUAT
        $roleAdmin = Role::findByName('admin');
        $roleDirektur = Role::findByName('direktur');
        $roleManajer = Role::findByName('manajer');
        $roleStaf = Role::findByName('staf');

        // 3. BERIKAN PERMISSIONS KE SETIAP ROLE
        // Direktur bisa melakukan segalanya

        $roleDirektur->givePermissionTo(Permission::all());

        // Manajer bisa mengelola surat dan membuat disposisi
        $roleManajer->givePermissionTo([
            'kelola surat',
            'buat disposisi',
            'lihat semua surat',
        ]);

        // Staf hanya bisa mengelola surat yang dia buat (logika ini diatur di controller/policy)
        // Untuk seeder, kita berikan izin dasarnya.
        $roleStaf->givePermissionTo('kelola surat');
    }
}
