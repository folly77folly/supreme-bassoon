<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\PasswordChangeNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable implements MustVerifyEmail
{

    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = 'admin';
    protected $table = 'admins';

    protected $guarded = [];

    protected $hidden = [
        'password',
        'email_verified_at',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');

    }

    public function sendPasswordResetSuccessNotification()
    {

        $this->notify(new PasswordChangeNotification($fullName));
    }
}
