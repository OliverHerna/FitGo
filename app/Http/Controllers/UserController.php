<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Role;
use Illuminate\Support\Facades\Auth;
use App\Entity;
use App\Log as AppLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Mail\AccessMessage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewUser;
use App\Paquete;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::withTrashed()->get();
        return view('control_panel.users.index')->with([
            'users' => $users,
            'email_filter' => $request->input('email', ''),
            'name_filter' => $request->input('name', ''),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $paquetes = Paquete::all();

        return view('control_panel.users.create')->with([
            'roles' => $roles,
            'paquetes' => $paquetes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        DB::beginTransaction();

        try {
            $role = Role::find($request->role);
            $actualUser = Auth::user();
            $passwordClient = Str::random(8);
            $user = new User();
            $entity = new Entity();
            $log = new AppLog();
            $first_name = $request->first_name;
            $paquete = Paquete::find($request->paquete);

            $user->first_name = mb_convert_case($first_name, MB_CASE_TITLE);
            $user->last_name = mb_convert_case($request->last_name, MB_CASE_TITLE);
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->company_name = $request->company_name;

            if ($role->id === 3) {
                $passwordClient = Str::random(8);
                $user->password = bcrypt($passwordClient);
            } else {
                $passwordClient = $request->password;
                $user->password = bcrypt($request->password);
            }

            $user->role()->associate($role);
            $user->save();

            $entity->entitiabble()->associate($user);
            $entity->save();

            $log->user()->associate($actualUser);
            $log->entity()->associate($entity);
            $log->message = "Creación de nuevo usuario";
            $log->save();

            Log::info("Store -> id: $user->id entity: $entity->id user:$actualUser->id role: " . $actualUser->role->name);

            $user->notify(new NewUser($passwordClient, $first_name));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            abort('500');
        }


        if ($role->id === 3 && $paquete != NULL) {
            return redirect()->route('storePaqueteUser', ['user' => $user, 'paquete' => $paquete]);
        } else {
            return redirect()->route('usuarios.show', $user)->with([
                'success' => 'Usuario creado correctamente'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('control_panel.users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();

        return view('control_panel.users.edit')->with([
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, User $user)
    {
        DB::beginTransaction();

        try {
            $role = Role::find($request->role);
            $actualUser = Auth::user();
            $log = new AppLog();
            $entity = $user->entity;

            if (!$entity) {
                $entity = new Entity();
                $entity->entitiabble()->associate($user);
                $entity->save();
            } else {
                $user->entity->save();
            }

            $user->first_name = mb_convert_case($request->first_name, MB_CASE_TITLE);
            $user->last_name = mb_convert_case($request->last_name, MB_CASE_TITLE);
            $user->email = $request->email;
            $user->phone = $request->phone;

            if ($role->id === 3) {
                $user->company_name = $request->company_name;
            } else {
                $user->company_name = NULL;
            }

            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $user->role()->associate($role);
            $user->save();

            $log->user()->associate($actualUser);
            $log->entity()->associate($entity);
            $log->message = "Actualización de usuario";
            $log->save();

            Log::info("Update -> id: $user->id entity: " . $entity . " user: $actualUser->id role: " . $actualUser->role->name);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            abort('500');
        }

        return redirect()->route('usuarios.show', $user)->with([
            'success' => 'Usuario editado correctamente'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();

        try {
            $actualUser = Auth::user();
            $log = new AppLog();

            $user->entity->save();
            $user->delete();

            $log->user()->associate($actualUser);
            $log->entity()->associate($user->entity);
            $log->message = "Eliminación de usuario";
            $log->save();

            Log::info("Destroy -> id: $user->id entity: " . $user->entity->id . " user:$actualUser->id role: " . $actualUser->role->name);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            abort('500');
        }

        return redirect()->route('usuarios.index')->with([
            'success' => 'Usuario eliminado correctamente'
        ]);
    }
    /**
     * Un-delete the specified resorce from storage
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $user)
    {
        DB::beginTransaction();

        try {
            $user = User::withTrashed()->find($user);
            $actualUser = Auth::user();
            $log = new AppLog();

            $this->authorize('restore', $user);

            $user->restore();
            $user->entity->save();

            $log->user()->associate($actualUser);
            $log->entity()->associate($user->entity);
            $log->message = "Restauración de usuario";
            $log->save();

            Log::info("Restore -> id: $user->id entity: " . $user->entity->id . " user:$actualUser->id role: " . $actualUser->role->name);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            abort('500');
        }

        return redirect()->route('usuarios.index')->with([
            'success' => 'Usuario restaurado correctamente'
        ]);
    }

    /**
     * Permanent delete the specified resource from storage
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(Request $request, $user)
    {
        DB::beginTransaction();

        try {
            $user = User::withTrashed()->find($user);
            $actualUser = Auth::user();
            $log = new AppLog();

            $this->authorize('forceDelete', $user);

            $user->forceDelete();
            $user->entity->save();

            $log->user()->associate($actualUser);
            $log->entity()->associate($user->entity);
            $log->message = "Eliminación permanente de usuario";
            $log->save();

            Log::info("Force delete -> id: $user->id entity: " . $user->entity->id . " user:$actualUser->id role: " . $actualUser->role->name);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            abort('500');
        }

        return redirect()->route('usuarios.index')->with([
            'success' => 'Usuario eliminado permanentemente'
        ]);
    }

    /**
     * Return the list of logs related to all users
     *
     * @return \Illuminate\Http\Response
     */
    public function log(Request $request)
    {
        $logs = AppLog::all();

        return view('control_panel.users.log')->with([
            'logs' => $logs,
        ]);
    }
}