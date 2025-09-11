<?php

namespace App\Models\Auth;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'account_status', // 'pending', 'active', 'suspended'
        'last_login',
        'device_info',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'last_login' => 'datetime',
    ];

    // Relation avec les rôles
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    // Relation avec le portefeuille
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    // Vérifie si l'utilisateur a un rôle spécifique
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    // Vérifie si l'utilisateur a plusieurs rôles
    public function hasAnyRole(array $roles)
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    // Assigner un rôle à l'utilisateur
    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->firstOrFail();
        }

        $this->roles()->syncWithoutDetaching($role);
    }
}
