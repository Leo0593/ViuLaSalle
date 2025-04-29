<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';

    protected $fillable = [
        'creador_id',
        'titulo',
        'mensaje',
        'es_global',
        'status',
    ];

    // 🔁 Creador de la notificación
    public function creador()
    {
        return $this->belongsTo(User::class, 'creador_id');
    }

    // 🔁 Usuarios destinatarios (muchos a muchos)
    public function destinatarios()
    {
        return $this->belongsToMany(User::class, 'notificacion_user', 'notificacion_id', 'user_id')
            ->withPivot('leido')
            ->withTimestamps();
    }



}
// 