<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ColeccionUser extends Pivot
{
    protected $table = 'coleccion_user';

    protected $fillable = [
        'user_id',
        'coleccion_id',
        // Si agregas más campos como permisos, agrégalos aquí
    ];

    // Si usas timestamps en la tabla pivot (lo estás haciendo), esto es útil:
    public $timestamps = true;

    // Relaciones (opcional)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coleccion()
    {
        return $this->belongsTo(Coleccion::class);
    }
}

