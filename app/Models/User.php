<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
// mmhv
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'status',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Notificaciones que ha creado este usuario
    public function notificacionesCreadas()
    {
        return $this->hasMany(Notificacion::class, 'creador_id');
    }

    // Notificaciones que ha recibido este usuario
    public function notificacionesRecibidas()
    {
        return $this->belongsToMany(Notificacion::class, 'notificacion_user')
            ->withPivot('leido')
            ->withTimestamps();
    }

    // Relación: el usuario puede acceder a muchas colecciones
    public function colecciones(): BelongsToMany
    {
        return $this->belongsToMany(Coleccion::class, 'coleccion_user')
            ->using(ColeccionUser::class)
            ->withTimestamps();
    }


    // Relación: el usuario puede haber creado muchas colecciones
    public function coleccionesCreadas()
    {
        return $this->hasMany(Coleccion::class, 'creador_id');
    }

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class, 'id_user');
    }
}
