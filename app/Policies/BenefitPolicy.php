<?php

namespace App\Policies;

use App\Benefit;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BenefitPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'Benefit');
        })->first();

        return filled($permission);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Benefit  $benefit
     * @return mixed
     */
    public function view(User $user, Benefit $benefit)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'Benefit');
        })->first();

        return isset($permission->view) ? $permission->view : false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'Benefit');
        })->first();

        return isset($permission->create) ? $permission->create : false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Benefit  $benefit
     * @return mixed
     */
    public function update(User $user, Benefit $benefit)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'Benefit');
        })->first();

        return isset($permission->update) ? $permission->update : false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Benefit  $benefit
     * @return mixed
     */
    public function delete(User $user, Benefit $benefit)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Benefit  $benefit
     * @return mixed
     */
    public function restore(User $user, Benefit $benefit)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Benefit  $benefit
     * @return mixed
     */
    public function forceDelete(User $user, Benefit $benefit)
    {
        //
    }
}
