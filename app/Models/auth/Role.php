<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'description'];

    // Constantes pour les rôles principaux
    const ROLE_ADMIN = 'admin';
    const ROLE_PROPERTY_OWNER = 'property_owner';
    const ROLE_INVESTOR = 'investor';
    const ROLE_USER = 'user';

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public function hasPermission($permission)
    {
        return $this->permissions()->where('name', $permission)->exists();
    }
}
