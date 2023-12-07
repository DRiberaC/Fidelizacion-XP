<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recompensa extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'detalle',
        'puntos',
    ];

    public function historial()
    {
        return $this->hasMany(RecompensaHistorial::class);
    }

    public function obtenerAdiciones()
    {
        return $this->historial()
            ->where('tipo', 'incremento')
            ->sum('cantidad');
    }

    public function obtenerReclamos()
    {
        return $this->historial()
            ->where('tipo', 'decremento')
            ->sum('cantidad');
    }
}
