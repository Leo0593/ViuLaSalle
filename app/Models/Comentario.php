<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $table = 'comentarios'; // Nombre de la tabla en la BD

    protected $fillable = [
        'id_user',
        'id_publicacion',
        'contenido',
        'status'
    ];

    /**
     * Relación con el usuario (un comentario pertenece a un usuario).
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Relación con la publicación (un comentario pertenece a una publicación).
     */
    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class, 'id_publicacion');
    }

}
