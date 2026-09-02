<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carga extends Model
{


    use HasFactory;

    protected $table = 'cargas';

    protected $fillable = [
        'id_referencia',
        'observacion',
        'total',
        'nro_factura',
        'fecha_venta',
        'razon_social',
        'nit',
        'cantidad',
        'precio',
        'user_id',

        'factor',
        'puntos',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $existingCarga = Carga::where('id_referencia', $model->id_referencia)->exists();
            if ($existingCarga) {
                return false; // Si ya existe, abortar la creación del modelo
            }

            $placaClean = trim($model->observacion);
            $vehiculo = Vehiculo::where('placa', $placaClean)->first();

            $producto = Producto::where('precio', $model->precio)->first();
            $factor = $producto ? (float) $producto->factor : ((float) $model->factor > 0 ? (float) $model->factor : 1.0);

            $model->factor = $factor;
            $model->puntos = (float) $model->cantidad * $factor;

            if ($vehiculo && $vehiculo->user_id) {
                $model->user_id = $vehiculo->user_id;
            }
        });
    }
}
