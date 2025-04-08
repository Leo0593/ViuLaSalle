<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelEducativo extends Model
{
    use HasFactory;

    protected $table = 'nivel_educativo'; // Opcional si el nombre no es plural

    protected $fillable = [
        'nombre',
        'status'
    ];
}
