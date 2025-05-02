<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoColeccion extends Model
{
    use HasFactory;

    protected $table = 'fotos_coleccion';

    protected $fillable = [
        'publicacion_coleccion_id',
        'ruta_foto',
    ];

    public function publicacion()
    {
        return $this->belongsTo(PublicacionColeccion::class, 'publicacion_coleccion_id');
    }
}
