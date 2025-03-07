<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Publicacion extends Model
{
    use HasFactory;

    protected $table = 'publicaciones'; // Nombre de la tabla en la BD

    protected $fillable = [
        'id_user',
        'id_evento',
        'status',
        'descripcion',
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

    /**
     * Relación con el modelo FotoPublicacion (Una publicación tiene muchas fotos).
     */
    public function fotos(): HasMany
    {
        return $this->hasMany(FotoPublicacion::class, 'publicacion_id');
    }
}
