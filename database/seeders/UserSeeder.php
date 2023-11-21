<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@admin.com',
            'password' => bcrypt('password'),
            'subscription_start' => '2023-01-01'
        ]);

        $superAdminRole = Role::where('name', 'Super Admin')->first();

        if ($superAdminRole && $user) {
            $user->assignRole($superAdminRole);
        }
    }
}
