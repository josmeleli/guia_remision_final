<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class vehiculo extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

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
