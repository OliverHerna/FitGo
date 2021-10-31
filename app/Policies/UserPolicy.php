<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'User');
        })->first();

        return filled($permission);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'User');
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
            $query->where('name', 'User');
        })->first();

        return isset($permission->create) ? $permission->create : false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'User');
        })->first();

        return isset($permission->update) ? $permission->update : false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'User');
        })->first();

        return (isset($permission->delete) ? $permission->delete : false) == 1 &&
            $user->id !== $model->id &&
            $model->id !== 1 && $model->ActivePackage->first() == NULL;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function restore(User $user)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'User');
        })->first();

        return isset($permission->restore) ? $permission->restore : false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'User');
        })->first();

        return isset($permission->force_delete) ? $permission->force_delete : false;
    }

    /**
     * Determine whether the user can log.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function log(User $user)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'User');
        })->first();

        return isset($permission->log) ? $permission->log : false;
    }
}
