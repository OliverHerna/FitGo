<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Module;
use Illuminate\Support\Facades\DB;
use App\Log as AppLog;
use App\Entity;
use App\Permission;
use App\Http\Requests\StoreRole;
use App\Http\Requests\UpdateRole;
use Illuminate\Support\Facades\Log;
use Exception;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Role::class, 'role');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::withTrashed()->when($request->filled('name'), function ($query) use ($request) {
            return $query->where('name', 'like', "%$request->name%");
        })->paginate(8);

        return view('control_panel.roles.index')->with([
            'roles' => $roles,
            'role_filter' => $request->name,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = Module::all();

        return view('control_panel.roles.create')->with([
            'modules' => $modules,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRole $request)
    {
        DB::beginTransaction();

        try {
            $role = new Role();
            $actualUser = Auth::user();
            $entity = new Entity();
            $log = new AppLog();
            $modules = Module::all();

            $role->name = mb_convert_case($request->name, MB_CASE_TITLE);
            $role->save();

            $entity->entitiabble()->associate($role);
            $entity->save();

            foreach ($modules as $module) {
                $permissions = $request->input($module->name, '');

                if ($permissions) {
                    $permission = new Permission();

                    foreach ($permissions as $action) {
                        $action != 'view' ?: $permission->view = 1;
                        $action != 'create' ?: $permission->create = 1;
                        $action != 'update' ?: $permission->update = 1;
                        $action != 'delete' ?: $permission->delete = 1;
                        $action != 'restore' ?: $permission->restore = 1;
                        $action != 'force_delete' ?: $permission->force_delete = 1;
                        $action != 'log' ?: $permission->log = 1;
                    }

                    $permission->role()->associate($role);
                    $permission->module()->associate($module);
                    $permission->save();
                }
            }

            $log->user()->associate($actualUser);
            $log->entity()->associate($entity);
            $log->message = "Creación de nuevo rol";
            $log->save();

            Log::info("Store -> id: $role->id entity: $entity->id user:$actualUser->id role: " . $actualUser->role->name);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            abort('500');
        }

        return redirect()->route('roles.show', $role)->with([
            'success' => 'Rol creado correctamente'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $modules = Module::all();

        return view('control_panel.roles.show')->with([
            'role' => $role,
            'modules' => $modules,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = $role->permissions()->get();
        $modules = Module::all();

        return view('control_panel.roles.edit')->with([
            'role' => $role,
            'permissions' => $permissions,
            'modules' => $modules,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRole $request, Role $role)
    {
        DB::beginTransaction();

        try {
            $actualUser = Auth::user();
            $log = new AppLog();
            $modules = Module::all();
            $entity = $role->entity;

            if (!$entity) {
                $entity = new Entity();
                $entity->entitiabble()->associate($role);
                $entity->save();
            } else {
                $role->entity->save();
                $entity = $role->entity;
            }

            $role->name = mb_convert_case($request->name, MB_CASE_TITLE);
            $role->save();

            foreach ($modules as $module) {
                $permissions = $request->input($module->name, '');

                if ($permissions) {
                    $permission = $role->permissions()->whereHas('module', function ($query) use ($module) {
                        return $query->where('name', $module->name);
                    })->first();

                    if (!$permission) {
                        $permission = new Permission();
                    }

                    $permission->view = 0;
                    $permission->create = 0;
                    $permission->update = 0;
                    $permission->delete = 0;
                    $permission->restore = 0;
                    $permission->force_delete = 0;
                    $permission->log = 0;

                    foreach ($permissions as $action) {
                        if ($action != 'none') {
                            $permission->$action = 1;
                        }
                    }

                    $permission->role()->associate($role);
                    $permission->module()->associate($module);
                    $permission->save();
                } else {
                    $permission = $role->permissions()->whereHas('module', function ($query) use ($module) {
                        return $query->where('name', $module->name);
                    })->first();

                    if ($permission) {
                        $permission->delete();
                    }
                }
            }

            $log->user()->associate($actualUser);
            $log->entity()->associate($entity);
            $log->message = "Actualización de rol";
            $log->save();

            Log::info("Update -> id: $role->id entity: " . $entity->id . " user:$actualUser->id role: " . $actualUser->role->name);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            abort('500');
        }

        return redirect()->route('roles.show', $role)->with([
            'success' => 'Rol actualizado correctamente'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        DB::beginTransaction();

        try {
            $actualUser = Auth::user();
            $log = new AppLog();

            $role->entity->save();
            $role->delete();

            $log->user()->associate($actualUser);
            $log->entity()->associate($role->entity);
            $log->message = "Eliminación de rol";
            $log->save();

            Log::info("Destroy -> id: $role->id entity: " . $role->entity->id . " user:$actualUser->id role: " . $actualUser->role->name);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            abort('500');
        }

        return redirect()->route('roles.index')->with([
            'success' => 'Rol eliminado correctamente'
        ]);
    }

    /**
     * Un-delete the specified resorce from storage
     *
     * @param \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $role)
    {
        DB::beginTransaction();

        try {
            $role = Role::withTrashed()->find($role);
            $actualUser = Auth::user();
            $log = new AppLog();

            $this->authorize('restore', $role);

            $role->restore();
            $role->entity->save();

            $log->user()->associate($actualUser);
            $log->entity()->associate($role->entity);
            $log->message = "Restauración de rol";
            $log->save();

            Log::info("Restore -> id: $role->id entity: " . $role->entity->id . " user:$actualUser->id role: " . $actualUser->role->name);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            abort('500');
        }

        return redirect()->route('roles.index')->with([
            'success' => 'Rol restaurado correctamente'
        ]);
    }

    /**
     * Permanent delete the specified resource from storage
     *
     * @param \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(Request $request, $role)
    {
        DB::beginTransaction();

        try {
            $role = Role::withTrashed()->find($role);
            $actualUser = Auth::user();
            $log = new AppLog();

            $this->authorize('forceDelete', $role);

            foreach ($role->permissions as $permission) {
                $permission->delete();
            }

            $role->forceDelete();
            $role->entity->save();

            $log->user()->associate($actualUser);
            $log->entity()->associate($role->entity);
            $log->message = "Eliminación permanente de rol";
            $log->save();

            Log::info("Force delete -> id: $role->id entity: " . $role->entity->id . " user:$actualUser->id role: " . $actualUser->role->name);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            abort('500');
        }

        return redirect()->route('roles.index')->with([
            'success' => 'Rol eliminado permanentemente'
        ]);
    }
}
