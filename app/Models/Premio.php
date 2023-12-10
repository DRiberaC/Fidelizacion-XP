<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Premio extends Model
{
    use HasFactory;

    protected $table = 'premios';

    protected $fillable = [
        'name',
        'detalle',
        'puntos',
    ];

    public function historial()
    {
        return $this->hasMany(PremioHistorial::class);
    }

    public function obtenerAdiciones()
    {
        $adiciones = $this->historial()
            ->where('tipo', 'incremento')
            ->sum('cantidad');
        return $adiciones;
    }

    public function obtenerReclamos()
    {
        $reclamos = $this->historial()
            ->where('tipo', 'decremento')
            ->sum('cantidad');
        return $reclamos;
    }
}
