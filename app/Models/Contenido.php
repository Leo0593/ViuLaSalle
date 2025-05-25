<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contenido extends Model
{
    protected $table = 'contenido'; // Si tu tabla se llama diferente al plural del modelo

    protected $fillable = [
        'id_vista',
        'vista_tipo',
        'tipo',
        'titulo',
        'descripcion',
        'imagen',
        'video',
        'opcion',
        'status',
        
    ];
}
