<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat Permissions (Hak Akses)
        Permission::create(['name' => 'kelola surat']);
        Permission::create(['name' => 'kirim disposisi']);
        Permission::create(['name' => 'kelola pengguna']);
        Permission::create(['name' => 'kelola surat keluar']);
        // Buat Roles (Peran)
        $roleAdmin = Role::create(['name' => 'admin']);
        $rolePimpinan = Role::create(['name' => 'pimpinan']);
        $roleStaf = Role::create(['name' => 'staf']);

        // Berikan Permissions ke Roles
        // Pimpinan bisa mengelola surat dan mengirim disposisi
        $rolePimpinan->givePermissionTo([
            'kelola surat',
            'kirim disposisi',
            'kelola surat keluar',
        ]);

        // Admin bisa melakukan semuanya
        $roleAdmin->givePermissionTo(Permission::all());
    }
}
