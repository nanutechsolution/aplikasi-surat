<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        DB::table('notifications')->truncate();

        $this->call([
            RolePermissionSeeder::class
        ]);

        // Buat user Admin dan berikan peran 'admin'
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        $admin->assignRole('admin');

        // Buat user Pimpinan dan berikan peran 'pimpinan'
        $pimpinan = User::factory()->create([
            'name' => 'Pimpinan User',
            'email' => 'pimpinan@example.com',
        ]);
        $pimpinan->assignRole('pimpinan');

        // Buat 3 user Staf dan berikan peran 'staf'
        $stafUsers = User::factory()->count(3)->create();
        foreach ($stafUsers as $staf) {
            $staf->assignRole('staf');
        }
    }
}
