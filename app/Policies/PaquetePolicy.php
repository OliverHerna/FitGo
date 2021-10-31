<?php

namespace App\Policies;

use App\Paquete;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaquetePolicy
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
            $query->where('name', 'Paquete');
        })->first();

        return filled($permission);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Paquete  $paquete
     * @return mixed
     */
    public function view(User $user, Paquete $paquete)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'Paquete');
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
            $query->where('name', 'Paquete');
        })->first();

        return isset($permission->create) ? $permission->create : false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Paquete  $paquete
     * @return mixed
     */
    public function update(User $user, Paquete $paquete)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'Paquete');
        })->first();

        return isset($permission->update) ? $permission->update : false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Paquete  $paquete
     * @return mixed
     */
    public function delete(User $user, Paquete $paquete)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Paquete  $paquete
     * @return mixed
     */
    public function restore(User $user, Paquete $paquete)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Paquete  $paquete
     * @return mixed
     */
    public function forceDelete(User $user, Paquete $paquete)
    {
        //
    }
}
