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

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function unreadMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id')->where('read', false);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'first_name',
        'last_name',
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

    // app/Models/User.php
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    // Check if user has a specific role
    public function hasRole($role)
    {
        return $this->roles->contains('name', $role);
    }

    // Check if user has a specific permission
    public function hasPermission($permission)
    {
        foreach ($this->roles as $role) {
            if ($role->permissions->contains('name', $permission)) {
                return true;
            }
        }

        return false;
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'user_id');
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function crowdfundingProjects()
    {
        return $this->hasMany(CrowdfundingProject::class);
    }

    public function crowdfundingInvestments()
    {
        return $this->hasMany(CrowdfundingInvestment::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
}
