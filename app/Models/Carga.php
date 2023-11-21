<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carga extends Model
{
    use HasFactory;
    protected $fillable = [
        'observacion',
        'total',
        'nro_factura',
        'fecha_venta',
        'razon_social',
        'nit',
        'cantidad',
        'precio',
        'user_id',
    ];
}
