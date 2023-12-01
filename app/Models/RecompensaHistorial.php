<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecompensaHistorial extends Model
{
    use HasFactory;

    protected $table = 'recompensa_historial';

    protected $fillable = [
        'tipo',
        'cantidad',
        'detalle',
        'recompensa_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function recompensa()
    {
        return $this->belongsTo(Recompensa::class, 'recompensa_id');
    }
}
