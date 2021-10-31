<?php

namespace App\Http\Controllers;

use App\Benefit;
use App\Http\Requests\StorePaqueteUser;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\User;
use App\Paquete;
use App\PaqueteUser;
use Illuminate\Support\Facades\Auth;

class PaqueteUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(PaqueteUser::class, 'paquete_users');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*
*/
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($user, $paquete)
    {
        /*
        $user_c = User::findOrFail(4);
        return $user_c->paquete_user[0]->users->first_name;
        */
        DB::beginTransaction();

        try {
            //Encuentra el usuario
            $user_c = User::findOrFail($user);
            $paquete_c = Paquete::findOrFail($paquete);
            $user_c->paquetes()->attach($paquete_c, ['benefit_id' => $paquete_c->benefit_id]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            abort('500');
        }

        return redirect()->route('usuarios.show', $user)->with([
            'success' => 'Cliente creado correctamente con un paquete'
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePackageClient(StorePaqueteUser $request)
    {
        /*
        $user_c = User::findOrFail(4);
        return $user_c->paquete_user[0]->users->first_name;
        */
        DB::beginTransaction();
        $user = intval($request->client);
        $package = intval($request->package);
        try {
            //Encuentra el usuario
            $user_c = User::findOrFail($user);
            $paquete_c = Paquete::findOrFail($package);
            $user_c->paquetes()->attach($paquete_c, ['benefit_id' => $paquete_c->benefit_id]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            abort('500');
        }

        return redirect()->route('usuarios.show', $user)->with([
            'success' => 'Se ha asignado correctamente un paquete'
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile(User $user)
    {
        $user_c = Auth::user();
        // $hours_spent =
        //Function to only show the profile from a user with role client
        if ($user->role->id == 3) {
            if ($user_c->role->id < 3) {
                return view('cliente.show')->with('user', $user);
            } elseif ($user->id == $user_c->id) {

                return view('cliente.show')->with('user', $user);
            }

            \abort('404');
        }
        \abort('404');
        // $this->authorize('perfil');
    }

    public function description_modal()
    {
        $description = $this->input->post("description");

        return "Hola";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
