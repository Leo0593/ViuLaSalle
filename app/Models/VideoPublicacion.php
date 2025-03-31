<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoPublicacion extends Model
{
    use HasFactory;

    protected $table = 'videos_publicaciones';

    protected $fillable = [
        'publicacion_id',
        'ruta_video',
    ];

    /**
     * Relación con Publicacion
     */
    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class);
    }
}
