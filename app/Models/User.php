<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'ci_nit',
        'subscription_start',
        'email',
        'password',
    ];

    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class);
    }

    public function cargas()
    {
        return $this->hasMany(Carga::class);
    }

    public function premios()
    {
        return $this->hasMany(PremioHistorial::class);
    }

    public function puntosReclamados()
    {
        // $total = $this->premios()
        //     ->sum('cantidad * puntos');
        $total = $this->premios()
            ->select(DB::raw('SUM(cantidad * puntos) as total_puntos'))
            ->value('total_puntos');
        return $total;
    }

    public function getGNV()
    {
        $gnv = $this->sumCantidadWithPrice("1.66");
        return $gnv;
    }

    public function getGAS()
    {
        $gas = $this->sumCantidadWithPrice("3.74");
        return $gas;
    }

    public function getDIS()
    {
        $dis = $this->sumCantidadWithPrice("3.72");
        return $dis;
    }

    public function sumCantidadWithPrice($price)
    {
        $total = $this->cargas()
            ->where('precio', $price)
            ->sum('puntos');
        return $total;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            // Buscar el rol "Cliente"
            $clienteRole = Role::where('name', 'Cliente')->first();

            // Asignar el rol "Cliente" al usuario
            if ($clienteRole && $model) {
                $model->assignRole($clienteRole);
            }
        });
    }
}
