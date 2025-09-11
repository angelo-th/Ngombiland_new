<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'description'];

    // Basic permissions constants
    const MANAGE_PROPERTIES = 'manage_properties';

    const INVEST_IN_PROJECTS = 'invest_in_projects';

    const CREATE_CROWDFUNDING = 'create_crowdfunding';

    const MANAGE_USERS = 'manage_users';
}
