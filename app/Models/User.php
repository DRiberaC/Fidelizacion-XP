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
    const Gasolina_18_dec_2025 = 6.96;
    const Diesel_18_dec_2025 = 9.80;
    const GNV_18_dec_2025 = 2.73;

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
        'telefono',
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
        $total = $this->premios()
            ->where('tipo', 'decremento')
            ->select(DB::raw('SUM(cantidad * puntos) as total_puntos'))
            ->value('total_puntos');
        return $total ? (float) $total : 0.0;
    }

    public function getPuntosTotales()
    {
        $total = $this->cargas()->sum('puntos');
        return $total ? (float) $total : 0.0;
    }

    public function getGNV()
    {
        $precios = Producto::where('name', 'LIKE', '%GNV%')->pluck('precio')->toArray();
        if (empty($precios)) {
            $precios = ["1.66", self::GNV_18_dec_2025];
        }
        return (float) $this->cargas()->whereIn('precio', $precios)->sum('puntos');
    }

    public function getGAS()
    {
        $precios = Producto::where('name', 'LIKE', '%GAS%')->pluck('precio')->toArray();
        if (empty($precios)) {
            $precios = ["3.74", self::Gasolina_18_dec_2025];
        }
        return (float) $this->cargas()->whereIn('precio', $precios)->sum('puntos');
    }

    public function getDIS()
    {
        $precios = Producto::where('name', 'LIKE', '%DIESEL%')->orWhere('name', 'LIKE', '%DIS%')->pluck('precio')->toArray();
        if (empty($precios)) {
            $precios = ["3.72", self::Diesel_18_dec_2025];
        }
        return (float) $this->cargas()->whereIn('precio', $precios)->sum('puntos');
    }

    public function sumCantidadWithPrice($price)
    {
        $total = $this->cargas()
            ->where('precio', $price)
            ->sum('puntos');
        return $total ? (float) $total : 0.0;
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
