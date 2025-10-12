<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ====== Buat Permission (Hak Akses) ======
        $permissions = [
            'kelola surat',
            'kelola surat keluar',
            'kirim disposisi',
            'kelola pengguna',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ====== Buat Role ======
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleDirektur = Role::firstOrCreate(['name' => 'direktur']);
        $roleKa = Role::firstOrCreate(['name' => 'ka']);
        $roleWaka = Role::firstOrCreate(['name' => 'waka']);
        $roleStaf = Role::firstOrCreate(['name' => 'staf']);

        // ====== Berikan Permission ke Role ======
        // Admin boleh semua
        $roleAdmin->givePermissionTo(Permission::all());

        // Direktur — biasanya approve surat dan disposisi
        $roleDirektur->givePermissionTo([
            'kelola surat',
            'kelola surat keluar',
            'kirim disposisi',
        ]);

        // KA dan WAKA — biasanya dapat disposisi dan bisa teruskan
        $roleKa->givePermissionTo([
            'kelola surat',
            'kirim disposisi',
        ]);

        $roleWaka->givePermissionTo([
            'kelola surat',
            'kirim disposisi',
        ]);

        // Staf — biasanya hanya kelola surat dan terima disposisi
        $roleStaf->givePermissionTo([
            'kelola surat',
        ]);
    }
}
