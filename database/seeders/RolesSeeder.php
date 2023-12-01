<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Super Admin',
            'Operador',
            'Cliente',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
