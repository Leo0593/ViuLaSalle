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

    public function cursos()
    {
        return $this->hasMany(Curso::class, 'id_nivel');
    }

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
