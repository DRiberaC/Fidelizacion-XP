<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CabeceraPremioHistorial extends Model
{
    use HasFactory;
    protected $table = 'cabecera_premio_historial';

    protected $fillable = [
        'detalle',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function premioHistoriales()
    {
        return $this->hasMany(PremioHistorial::class, 'cabecera_id');
    }
}
