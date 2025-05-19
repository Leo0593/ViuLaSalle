<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CookieConsent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'consent_version',
        'consent_given_at',
    ];

    protected $dates = ['consent_given_at'];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
