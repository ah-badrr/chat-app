<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Chat;
use App\Models\Contact;
use App\Models\Membership;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "user";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        'password' => 'hashed',
    ];

    public function sender()
    {
        return $this->hasMany(Chat::class, 'from', 'id');
    }

    public function receiver()
    {
        return $this->hasMany(Chat::class, 'to', 'id');
    }

    public function membership()
    {
        return $this->hasMany(Membership::class, 'user_id', 'id');
    }

    public function conmake()
    {
        return $this->hasMany(Contact::class, 'maker', 'id');

    }

    public function conrec()
    {
        return $this->hasMany(Contact::class, 'receiver', 'id');
    }

}
