<?php

namespace App\Policies;

use App\User;
use App\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
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
     * Determine whether the user can view any roles.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'Role');
        })->first();

        return filled($permission);
    }

    /**
     * Determine whether the user can view the role.
     *
     * @param  \App\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function view(User $user)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'Role');
        })->first();

        return isset($permission->view) ? $permission->view : false;
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'Role');
        })->first();

        return isset($permission->create) ? $permission->create : false;
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  \App\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function update(User $user, Role $role)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'Role');
        })->first();

        return (isset($permission->update) ? $permission->update : false) == 1 && $role->id != 1;
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  \App\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function delete(User $user, Role $role)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'Role');
        })->first();

        $delete = $permission->delete;
        return (isset($delete) ? $delete : false) == 1 && $user->role != $role && !count($role->users()->get()) && $role->id > 3;
    }

    /**
     * Determine whether the user can restore the role.
     *
     * @param  \App\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function restore(User $user)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'Role');
        })->first();

        return isset($permission->restore) ? $permission->restore : false;
    }

    /**
     * Determine whether the user can permanently delete the role.
     *
     * @param  \App\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        $permission = $user->role->permissions()->whereHas('module', function ($query) {
            $query->where('name', 'Role');
        })->first();

        return isset($permission->force_delete) ? $permission->force_delete : false;
    }
}
