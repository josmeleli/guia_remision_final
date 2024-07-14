<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    use HasFactory;

    protected $table = 'audits';

    protected $fillable = [
        'user_id',
        'event',
        'auditable_type',
        'old_values',
        'new_values',
        'created_at',
    ];

    
}
