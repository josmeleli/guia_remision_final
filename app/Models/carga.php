<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class carga extends Model
{
    use HasFactory;
    protected $fillable = [
        'chofer_id',
        'total_carga_bruta',
        'total_carga_neta',
        'total_material_extrano',
        'tara',
        'nro_ticket',
        'km_origen',
        'km_de_destino',
        'fecha_carga',
        'fecha_de_descarga',
    ];

    public function chofer()
    {
        return $this->belongsTo(Chofer::class, 'chofer_id');
    }

    public function campos()
    {
        return $this->hasMany(Campo::class, 'carga_id');
    }
}
