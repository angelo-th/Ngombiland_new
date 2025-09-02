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
class Role extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];
    public function users() { return $this->hasMany(User::class); }
}
// Assign roles
$user->assignRole('client'); // Roles: client, agent, admin, super-admin

// Check permissions
if ($user->can('approve-properties')) {
    // Show approve button
}
if ($user->hasRole('admin')) {
    // Admin specific logic
}
Schema::table('users', function (Blueprint $table) {
    $table->string('role')->default('client'); // simple role system
});
