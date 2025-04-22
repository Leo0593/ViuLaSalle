<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FotoCurso extends Model
{
    use HasFactory;

    protected $table = 'fotos_curso';

    protected $fillable = [
        'curso_id',
        'ruta_imagen',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
