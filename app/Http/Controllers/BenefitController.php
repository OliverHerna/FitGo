<?php

namespace App\Http\Controllers;

use App\Benefit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Log as AppLog;
use App\Entity;
use Carbon\Carbon;
use App\Http\Requests\StoreBenefit;
use App\Http\Requests\UpdateBenefit;
use Dotenv\Result\Success;
use PhpParser\Node\Stmt\TryCatch;

class BenefitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Benefit::class, 'benefit');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $benefits = Benefit::all();
        return view('control_panel.benefits.index')->with([
            'benefits' => $benefits,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('control_panel.benefits.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBenefit $request)
    {

        DB::beginTransaction();

        try {
            $benefit = new Benefit();
            $actualUser = Auth::user();
            $entity = new Entity();
            $log = new AppLog();


            $request->today_date;
            $benefit->name = mb_convert_case($request->name, MB_CASE_TITLE);
            $benefit->description = $request->description;
            $benefit->validity = Carbon::createFromFormat('d/m/Y', $request->validity)->format('Y/m/d');
            $benefit->save();


            $entity->entitiabble()->associate($benefit);
            $entity->save();

            $log->user()->associate($actualUser);
            $log->entity()->associate($entity);
            $log->message = "Creación de nuevo benefit";
            $log->save();

            Log::info("Store -> id: $benefit->id entity: $entity->id user:$actualUser->id role: " . $actualUser->role->name);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            abort('500');
        }

        return redirect()->route('benefits.show', $benefit)->with([
            'success' => 'Beneficio creado correctamente'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Benefit  $benefit
     * @return \Illuminate\Http\Response
     */
    public function show(Benefit $benefit)
    {
        return view('control_panel.benefits.show')->with([
            'benefit' => $benefit,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Benefit  $benefit
     * @return \Illuminate\Http\Response
     */
    public function edit(Benefit $benefit)
    {
        return view('control_panel.benefits.edit')->with([
            'benefit' => $benefit,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Benefit  $benefit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBenefit $request, Benefit $benefit)
    {

        DB::beginTransaction();

        try {
            $actualUser = Auth::user();
            $log = new AppLog();
            $entity = $benefit->entity;

            if (!$entity) {
                $entity = new Entity();
                $entity->entitiabble()->associate($benefit);
                $entity->save();
            } else {
                $benefit->entity->save();
            }

            $request->today_date;
            $benefit->name = mb_convert_case($request->name, MB_CASE_TITLE);
            $benefit->description = $request->description;
            $benefit->validity = Carbon::createFromFormat('d/m/Y', $request->validity)->format('Y/m/d');
            $benefit->save();


            $log->user()->associate($actualUser);
            $log->entity()->associate($entity);
            $log->message = "Actualización de benefit";
            $log->save();

            //Log::info("Update -> id: $benefit->id entity: $entity->id user:$actualUser->id role: " . $actualUser->benefit->name);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            abort('500');
        }

        return redirect()->route('benefits.show', $benefit)->with([
            'success' => 'Beneficio actualizado correctamente',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Benefit  $benefit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Benefit $benefit)
    {
        //
    }
}
