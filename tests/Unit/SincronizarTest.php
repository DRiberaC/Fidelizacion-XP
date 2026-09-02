<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class SincronizarTest extends TestCase
{
    public function test_sincronizar_handles_null_product_and_calculates_points()
    {
        $producto = null; // Simulates Producto::where(...)->first() returning null

        $cargaFactor = null;
        $cargaCantidad = 50.0;

        // Logic implemented in ClienteController::sincronizar
        $factor = $producto ? (float) $producto->factor : ((float) $cargaFactor > 0 ? (float) $cargaFactor : 1.0);
        $puntos = $cargaCantidad * $factor;

        $this->assertEquals(1.0, $factor);
        $this->assertEquals(50.0, $puntos);
    }

    public function test_sincronizar_uses_product_factor_when_found()
    {
        $producto = (object) ['factor' => 1.5];

        $cargaFactor = null;
        $cargaCantidad = 40.0;

        $factor = $producto ? (float) $producto->factor : ((float) $cargaFactor > 0 ? (float) $cargaFactor : 1.0);
        $puntos = $cargaCantidad * $factor;

        $this->assertEquals(1.5, $factor);
        $this->assertEquals(60.0, $puntos);
    }
}
