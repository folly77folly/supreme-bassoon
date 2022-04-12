<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Notifications\EmailVerifyNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\PasswordChangeNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];
    protected $guarded = [

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean',
    ];

    public function sendEmailVerificationNotification()
    {
        $fullName = $this->fullName();
        $this->notify(new EmailVerifyNotification($fullName));
    }
    public function sendPasswordResetSuccessNotification()
    {
        $fullName = $this->fullName();
        $this->notify(new PasswordChangeNotification($fullName));
    }
    

    public function fullName(){
        return "{$this->first_name} {$this->last_name}" ;
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');

    }
}
