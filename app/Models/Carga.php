<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carga extends Model
{
    use HasFactory;
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
        });

        // static::created(function ($model) {
        //     $vehiculo = Vehiculo::where('placa', $model->observacion)->first();
        //     if ($vehiculo) {
        //         $model->user_id = $vehiculo->user_id;
        //         $model->save();
        //     }
        // });
    }
}
