<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class campo extends Model
{
    use HasFactory;

    protected $fillable = [
        'acopiadora',
        'ubigeo',
        'zona',
        'ingenio',
        'carga_id',
        'agricultor_id',
    ];
    public function carga()
    {
        return $this->belongsTo(Carga::class, 'carga_id');
    }
    public function agricultor()
    {
        return $this->belongsTo(Agricultor::class, 'agricultor_id');
    }


}
