<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class agricultor extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'ruc',
        'razon_social',
        'direccion',
        'apellidos',
        'nombres',
        'dni',
    ];

    // Definir la relación con el modelo GuiaRemision
    public function guias()
    {
        return $this->hasMany(Guia::class);
    }

    // Definir la relación con el modelo Campo
    public function campos()
    {
        return $this->hasMany(Campo::class);
    }
}
