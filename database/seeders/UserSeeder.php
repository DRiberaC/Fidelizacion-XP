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
        $admin = User::create([
            'name'     => 'Admin',
            'ci_nit' => '0000000',
            'email'    => 'admin@roes.com',
            'password' => bcrypt('password'),
            'subscription_start' => '2021-01-01'
        ]);

        $superAdminRole = Role::where('name', 'Super Admin')->first();

        if ($superAdminRole && $admin) {
            $admin->assignRole($superAdminRole);
        }

        $operador = User::create([
            'name'     => 'Operador',
            'ci_nit' => '0000001',
            'email'    => 'operador@roes.com',
            'password' => bcrypt('password'),
            'subscription_start' => '2021-01-01'
        ]);

        $operadorRole = Role::where('name', 'Operador')->first();

        if ($operadorRole && $operador) {
            $operador->assignRole($operadorRole);
        }
    }
}
