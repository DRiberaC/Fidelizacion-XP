<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Producto::create([
            'name'     => 'GNV',
            'detalle'    => '',
            'precio' => 1.66,
            'factor' => 1
        ]);

        Producto::create([
            'name'     => 'GASOLINA',
            'detalle'    => '',
            'precio' => 3.74,
            'factor' => 1
        ]);

        Producto::create([
            'name'     => 'DIESEL OIL',
            'detalle'    => '',
            'precio' => 3.72,
            'factor' => 1
        ]);
    }
}
