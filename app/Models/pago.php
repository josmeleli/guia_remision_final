<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pago extends Model
{
    use HasFactory;
    protected $fillable = ['agricultor_id', 'adelanto', 'tipo_pago', 'precio_unitario', 'num_pago'];

    // Relación con el modelo Agricultor
    public function agricultor()
    {
        return $this->belongsTo(Agricultor::class);
    }
}
