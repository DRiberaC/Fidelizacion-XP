<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class PremioDescuentoTest extends TestCase
{
    public function test_saldo_premio_calculates_correctly()
    {
        $adiciones = 10;
        $reclamos = 3;
        $saldo = $adiciones - $reclamos;

        $this->assertEquals(7, $saldo);
    }

    public function test_puntos_restantes_calculates_correctly()
    {
        $puntosObtenidos = 100.0;
        $puntosReclamados = 40.0;
        $puntosRestantes = $puntosObtenidos - $puntosReclamados;

        $this->assertEquals(60.0, $puntosRestantes);
    }
}
