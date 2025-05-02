<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicacionColeccion extends Model
{
    use HasFactory;

    protected $table = 'publicacion_coleccion';

    protected $fillable = [
        'user_id',
        'coleccion_id', // <- ¡Asegúrate de incluir esto aquí también!
        'descripcion',
        'fecha_publicacion',
        'status',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function coleccion()
    {
        return $this->belongsTo(Coleccion::class, 'coleccion_id');
    }

    public function fotos()
    {
        return $this->hasMany(FotoColeccion::class, 'publicacion_coleccion_id');
    }
}
