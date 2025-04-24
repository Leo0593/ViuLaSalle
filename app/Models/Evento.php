<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evento extends Model
{
    use HasFactory;

    // Definir los campos que pueden ser asignados masivamente
    protected $fillable = [
        'id_user',
        'status',
        'nombre',
        'descripcion',
        'fecha_publicacion',
        'foto',
    ];

    // Definir la relación con el modelo User (si es necesario)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class, 'id_evento');
    }

    public function categorias()
    {
        return $this->hasMany(Categoria::class, 'id_evento');
    }
    public function fotos()
    {
        return $this->hasMany(FotoPublicacion::class, 'evento_id');
    }
    public function videos()
    {
        return $this->hasMany(VideoPublicacion::class, 'evento_id');
    }
    public function getFechaPublicacionAttribute($value)
    {
        return \Carbon\Carbon::parse($value); // Convierte la fecha a una instancia de Carbon
    }
}