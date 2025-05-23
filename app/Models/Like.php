<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'publicacion_id'];

    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
