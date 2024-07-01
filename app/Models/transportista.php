<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transportista extends Model
{
    use HasFactory;

    protected $fillable = [
        'unidad_tecnica',
        'campo',
        'RUC',
        'razon_social',
        'codigo',
        'zona',
        'correo_electronico',
    ];

    // Relación con vehículos
    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class, 'id_transportista');
    }
}
