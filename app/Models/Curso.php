<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'curso';

    protected $fillable = [
        'id_nivel',
        'nombre',
        'duracion',
        'posibilidades_continuidad',
        'sector_profesional',
        'salidas_profesionales',
        'asignaturas_pdf',
        'status',
    ];

    public function nivelEducativo()
    {
        return $this->belongsTo(NivelEducativo::class, 'id_nivel');
    }

    public function fotos()
    {
        return $this->hasMany(FotoCurso::class);
    }
}
