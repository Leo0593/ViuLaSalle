<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;  // Asegúrate de importar Carbon


class Publicacion extends Model
{
    use HasFactory;

    protected $table = 'publicaciones'; // Nombre de la tabla en la BD

    protected $fillable = [
        'id_user',
        'id_evento',
        'status',
        'descripcion',
        'reportes',
        'likes',
        'activar_comentarios',
        'fecha_publicacion',
    ];

    /**
     * Relación con el modelo User (Una publicación pertenece a un usuario).
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Relación con el modelo Evento (Una publicación pertenece a un evento).
     */
    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class, 'id_evento');
    }

    public function getFechaPublicacionAttribute($value)
    {
        return Carbon::parse($value); // Convierte la fecha a una instancia de Carbon
    }

    /**
     * Relación con el modelo FotoPublicacion (Una publicación tiene muchas fotos).
     */
    public function fotos(): HasMany
    {
        return $this->hasMany(FotoPublicacion::class, 'publicacion_id');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(VideoPublicacion::class, 'publicacion_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_publicacion');
    }
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'categoria_publicacion');
    }



}
