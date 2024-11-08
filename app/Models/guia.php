<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class guia extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    
    protected $fillable = [
        'fecha_emision',
        'nro_guia',
        'nro_ticket',
        'fecha_partida',
        'punto_partida',
        'punto_llegada',
        'producto',
        'peso_bruto',
        'estado',
        'agricultor_id',
        'transportista_id',
    ];

    // Definir la relación con el modelo Agricultor
    public function agricultor()
    {
        return $this->belongsTo(Agricultor::class);
    }

    // Definir la relación con el modelo Transportista
    public function transportista()
    {
        return $this->belongsTo(Transportista::class);
    }
}
