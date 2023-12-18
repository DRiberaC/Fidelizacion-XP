<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremioHistorial extends Model
{
    use HasFactory;

    protected $table = 'premio_historial';

    protected $fillable = [
        'tipo',
        'cantidad',
        'puntos',
        'detalle',
        'premio_id',
        'user_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function recompensa()
    {
        return $this->belongsTo(Premio::class, 'premio_id');
    }
}
