<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'status',
        'nombre',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function publicaciones()
    {
        return $this->belongsToMany(Publicacion::class, 'categoria_publicacion');
    }

}
