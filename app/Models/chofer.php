<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class chofer extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    
    protected $table = 'chofers';
    protected $fillable = [
        'dni',
        'brevete',
        'nombre_apellidos',
        'telefono',
        
    ];

    // Relación con vehículos
    public function vehiculos()
    {
        return $this->belongsToMany(Vehiculo::class, 'chofer_vehiculos', 'chofer_id');
    }

    // Relación con cargas
    public function cargas()
    {
        return $this->hasMany(Carga::class, 'chofer_id');
    }
}
