<?php

namespace App\Policies;

use App\PaqueteUser;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class PaqueteUserPolicy
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
            $query->where('name', 'PaqueteUser');
        })->first();

        return filled($permission);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\PaqueteUser  $paqueteUser
     * @return mixed
     */
    public function view(User $user)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'PaqueteUser');
        })->first();

        return isset($permission->view) ? $permission->view : false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */

    public function profile(User $user)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'PaqueteUser');
        })->first();

        return isset($permission->view) ? $permission->view : false;
    }


    public function create(User $user)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'PaqueteUser');
        })->first();

        return isset($permission->view) ? $permission->view : false;
    }


        /**
     * Determine whether the user see the profile.
     *
     * @param  \App\User  $user
     * @param  \App\PaqueteUser  $paqueteUser
     * @return mixed
     */

    public function show(User $user){
    } 

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\PaqueteUser  $paqueteUser
     * @return mixed
     */
    public function update(User $user, PaqueteUser $paqueteUser)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\PaqueteUser  $paqueteUser
     * @return mixed
     */
    public function delete(User $user, PaqueteUser $paqueteUser)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\PaqueteUser  $paqueteUser
     * @return mixed
     */
    public function restore(User $user, PaqueteUser $paqueteUser)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\PaqueteUser  $paqueteUser
     * @return mixed
     */
    public function forceDelete(User $user, PaqueteUser $paqueteUser)
    {
        //
    }

    public function storePackageClient(User $user)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'PaqueteUser');
        })->first();

        return isset($permission->create) ? $permission->create : false;
    }
}
