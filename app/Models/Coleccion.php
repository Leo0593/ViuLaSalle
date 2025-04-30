<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Coleccion extends Model
{
    protected $table = 'colecciones';

    protected $fillable = [
        'creador_id',
        'nombre',
        'descripcion',
        'status',
    ];

    // Relación: una colección puede tener muchos usuarios
    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'coleccion_user')
            ->using(ColeccionUser::class)
            ->withTimestamps();
    }


    // Relación: una colección pertenece a un creador
    public function creador()
    {
        return $this->belongsTo(User::class, 'creador_id');
    }
}

