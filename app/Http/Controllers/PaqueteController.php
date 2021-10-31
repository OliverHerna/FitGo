<?php

namespace App\Http\Controllers;

use App\Benefit;
use App\Paquete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Log as AppLog;
use App\Entity;
use App\Http\Requests\StorePaquete;
use App\Http\Requests\UpdatePaquete;
use PhpParser\Node\Stmt\TryCatch;

class PaqueteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Paquete::class, 'paquete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paquetes = Paquete::all();

        return view('control_panel/paquetes/index')->with([
            'paquetes' => $paquetes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $benefits = Benefit::all();

        return view('control_panel/paquetes/create')->with([
            'benefits' => $benefits,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaquete $request)
    {

        DB::beginTransaction();

        try {
            $benefit = Benefit::find($request->benefit);
            $paquete = new Paquete();
            $actualUser = Auth::user();
            $entity = new Entity();
            $log = new AppLog();

            $paquete->name = mb_convert_case($request->name, MB_CASE_TITLE);
            $paquete->total_hours = $request->total_hours;
            if ($benefit != NULL) {
                $paquete->benefit()->associate($benefit);
            }
            $paquete->save();

            $entity->entitiabble()->associate($paquete);
            $entity->save();

            $log->user()->associate($actualUser);
            $log->entity()->associate($entity);
            $log->message = "Creación de nuevo paquete";
            $log->save();

            Log::info("Store -> id: $paquete->id entity: $entity->id user:$actualUser->id role: " . $actualUser->role->name);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            abort('500');
        }

        return redirect()->route('paquetes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Paquete  $paquete
     * @return \Illuminate\Http\Response
     */
    public function show(Paquete $paquete)
    {
        return view('control_panel.paquetes.show')->with([
            'paquete' => $paquete,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Paquete  $paquete
     * @return \Illuminate\Http\Response
     */
    public function edit(Paquete $paquete)
    {
        $benefits = Benefit::all();
        return view('control_panel.paquetes.edit')->with([
            'paquete' => $paquete,
            'benefits' => $benefits,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Paquete  $paquete
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaquete $request, Paquete $paquete)
    {
        DB::beginTransaction();

        try {
            $benefit = Benefit::find($request->benefit);
            $actualUser = Auth::user();
            $log = new AppLog();
            $entity = $paquete->entity;

            if (!$entity) {
                $entity = new Entity();
                $entity->entitiabble()->associate($paquete);
                $entity->save();
            } else {
                $paquete->entity->save();
            }

            $paquete->name = mb_convert_case($request->name, MB_CASE_TITLE);
            $paquete->total_hours = $request->total_hours;
            $paquete->benefit()->associate($benefit);
            $paquete->save();


            $log->user()->associate($actualUser);
            $log->entity()->associate($entity);
            $log->message = "Actualización de paquete";
            $log->save();

            //Log::info("Update -> id: $paquete->id entity: $entity->id user:$actualUser->id role: " . $actualUser->paquete->name);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            abort('500');
        }

        return redirect()->route('paquetes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Paquete  $paquete
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paquete $paquete)
    {
        //
    }
}
