<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificacionUser extends Model
{
    use HasFactory;

    protected $table = 'notificacion_user';

    protected $fillable = [
        'notificacion_id',
        'user_id',
        'leido',
    ];

    public function notificacion()
    {
        return $this->belongsTo(Notificacion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
