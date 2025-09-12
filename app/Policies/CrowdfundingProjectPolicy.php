<?php

namespace App\Policies;

use App\Models\CrowdfundingProject;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CrowdfundingProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Tout le monde peut voir les projets de crowdfunding
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CrowdfundingProject $crowdfundingProject): bool
    {
        return true; // Tout le monde peut voir un projet de crowdfunding
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['proprietor', 'agent', 'admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CrowdfundingProject $crowdfundingProject): bool
    {
        return $user->id === $crowdfundingProject->user_id || $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CrowdfundingProject $crowdfundingProject): bool
    {
        return $user->id === $crowdfundingProject->user_id || $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CrowdfundingProject $crowdfundingProject): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CrowdfundingProject $crowdfundingProject): bool
    {
        //
    }
}
