<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vehiculo extends Model
{
    use HasFactory;

    protected $fillable = [
        'placa',
        'placa1',
        'codigo',
        'dueño',
        'num_ejes',
        'id_transportista',
    ];

    // Definición de la relación con el transportista
    public function transportista()
    {
        return $this->belongsTo(Transportista::class, 'id_transportista');
    }

}
