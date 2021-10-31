<?php

namespace App\Http\Controllers;

use App\Client;
use App\User;
use App\Role;
use App\Paquete;
use App\Entity;
use App\Log as AppLog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Notifications\NewUser;
use App\Http\Requests\StoreUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Exports\ReportsExport;
use Maatwebsite\Excel\Facades\Excel;



class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Client::class, 'client');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = User::where('role_id', 3)->get();
        return view('cliente.index')->with([
            'clients' => $clients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::where('id', 3)->first();
        $paquetes = Paquete::all();
        return view('cliente.create')->with([
            'role' => $role,
            'paquetes' => $paquetes,
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
            $passwordClient = Str::random(8);
            $user->password = bcrypt($passwordClient);

            $user->role()->associate($role);
            $user->save();

            $entity->entitiabble()->associate($user);
            $entity->save();

            $log->user()->associate($actualUser);
            $log->entity()->associate($entity);
            $log->message = "Creación de nuevo cliente";
            $log->save();

            Log::info("Store -> id: $user->id entity: $entity->id user:$actualUser->id role: " . $actualUser->role->name);

            $user->notify(new NewUser($passwordClient, $first_name));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            abort('500');
        }

        if ($paquete != NULL) {
            return redirect()->route('storePaqueteUser', ['user' => $user, 'paquete' => $paquete]);
        } else {
            return redirect()->route('usuarios.show', $user)->with([
                'success' => 'Cliente creado correctamente'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }

    public function reports()
    {
        try
        {
            $actualUser = Auth::user();
            $entity = new Entity();
            $log = new AppLog();

            $entity->entitiabble()->associate($actualUser);
            $entity->save();

            $log->user()->associate($actualUser);
            $log->entity()->associate($entity);
            $log->message = "Descarga de Reporte";
            $log->save();

            Log::info("Download report total hours, user:$actualUser->id role: " . $actualUser->role->name);        
            
            return Excel::download(new ReportsExport, 'reports.xlsx');
        }
        catch (\Exception $e) {
            Log::error($e);
            abort('500');
        }
    }
    
}
