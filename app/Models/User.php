<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'password_changed_at',
        'branch'
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

    public function Collections(){
        return $this->hasMany(Collection::class, 'user_id');
    }
    public function customers(){
        return $this->hasMany(User::class, 'manager_id');
    }
    public function reqs(){
        return $this->hasMany(Req::class, 'operator_id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class, 'branch');
    }

    public function changePassword(){
        if($this->password_changed_at === null){
            return true;
        }
    }
}
