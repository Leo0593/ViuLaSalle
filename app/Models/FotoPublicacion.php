<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoPublicacion extends Model
{
    use HasFactory;

    protected $table = 'fotos_publicaciones'; // Nombre de la tabla en la BD

    protected $fillable = [
        'publicacion_id',
        'ruta_foto',
    ];

    /**
     * Relación con el modelo Publicacion (Cada foto pertenece a una publicación).
     */
    public function publicacion(): BelongsTo
    {
        return $this->belongsTo(Publicacion::class, 'publicacion_id');
    }
}
