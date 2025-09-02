<?php

namespace Database\Seeders;

// database/seeders/RolePermissionSeeder.php

use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Création des permissions
        $permissions = [
            Permission::MANAGE_PROPERTIES => 'Gérer les propriétés immobilières',
            Permission::INVEST_IN_PROJECTS => 'Investir dans des projets',
            Permission::CREATE_CROWDFUNDING => 'Créer des projets de crowdfunding',
            Permission::MANAGE_USERS => 'Gérer les utilisateurs',
        ];

        foreach ($permissions as $name => $description) {
            Permission::create(compact('name', 'description'));
        }

        // Création des rôles
        $roles = [
            Role::ROLE_ADMIN => 'Administrateur système',
            Role::ROLE_PROPERTY_OWNER => 'Propriétaire immobilier',
            Role::ROLE_INVESTOR => 'Investisseur',
            Role::ROLE_USER => 'Utilisateur standard',
        ];

        foreach ($roles as $name => $description) {
            Role::create(compact('name', 'description'));
        }

        // Assignation des permissions aux rôles
        $adminRole = Role::where('name', Role::ROLE_ADMIN)->first();
        $adminRole->permissions()->sync(Permission::all());

        $ownerRole = Role::where('name', Role::ROLE_PROPERTY_OWNER)->first();
        $ownerRole->permissions()->sync([
            Permission::where('name', Permission::MANAGE_PROPERTIES)->first()->id,
            Permission::where('name', Permission::CREATE_CROWDFUNDING)->first()->id,
        ]);

        $investorRole = Role::where('name', Role::ROLE_INVESTOR)->first();
        $investorRole->permissions()->sync([
            Permission::where('name', Permission::INVEST_IN_PROJECTS)->first()->id,
        ]);
    }
}