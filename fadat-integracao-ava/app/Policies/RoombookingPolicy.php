<?php

namespace App\Policies;

use App\Models\Roombooking;
use App\Constants\AccessLevels;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RoombookingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Roombooking $roombooking)
    {
        return true;
    }

    

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->access_level >= AccessLevels::ADMIN || $user->access_level === AccessLevels::MANAGER
            ? Response::allow()
            : Response::deny('Você não tem permissão para acessar este conteúdo');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user)
    {
        return $user->access_level >= AccessLevels::ADMIN || $user->access_level === AccessLevels::MANAGER
            ? Response::allow()
            : Response::deny('Você não tem permissão para acessar este conteúdo');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user)
    {
        return $user->access_level >= AccessLevels::ADMIN
            ? Response::allow()
            : Response::deny('Você não tem permissão para acessar este conteúdo');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user)
    {
        return $user->access_level === AccessLevels::SUPER_ADMIN
            ? Response::allow()
            : Response::deny('Você não tem permissão para acessar este conteúdo');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user)
    {
        return $user->access_level === AccessLevels::SUPER_ADMIN
            ? Response::allow()
            : Response::deny('Você não tem permissão para acessar este conteúdo');
    }
}
