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
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}