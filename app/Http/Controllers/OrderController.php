<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Log as AppLog;
use App\Entity;
use App\PaqueteUser;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrder;
use App\Http\Requests\UpdateOrder;
use App\Notifications\NewOrder;
use Exception;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Order::class, 'order');
    }

    public function index()
    {
        $users = User::has('paquete_user')->get();
        $orders = Order::all();
        return view('orders.index')->with([
            'orders' => $orders,
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //bring the users that have a package
        $users = User::all();
        $paquete_user = PaqueteUser::all();
        return view('orders.create')->with([
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrder $request)
    {
        DB::beginTransaction();
        try {
            $order = new Order();
            $user = User::find($request->user);
            //Llamada al ultimo paquete activo
            $paquete_user = $user->ActivePackage->first();
            $actualUser = Auth::user();
            $entity = new Entity();
            $log = new AppLog();

            if (!filled($paquete_user)) {
                return redirect()->back()->with([
                    'error' => 'No cuenta con un paquete activo'
                ]);
            }

            if (!self::validateHours($paquete_user, $request->hours)) {
                return redirect()->back()->with([
                    'error' => 'Ese paquete no cuenta con horas necesarias'
                ]);
            }


            $order->hours = $request->hours;
            $order->folio = $request->folio;
            $order->description = $request->description;
            $order->paquete_users()->associate($paquete_user);

            $order->save();

            $entity->entitiabble()->associate($order);
            $entity->save();


            $log->user()->associate($actualUser);
            $log->entity()->associate($entity);
            $log->message = "Creación de nuevo paquete";
            $log->save();

            $totalHours = 0;
            //Take the total hours from all the packages
            foreach ($user->ActivePackage as $infoPackage) {
                $totalHours = $totalHours + $infoPackage->HoursLeftValue;
            }
            //diference between total hours and spend hours
            $totalHours = $totalHours - $request->hours;

            Log::info("Store -> id: $order->id entity: $entity->id user:$actualUser->id role: " . $actualUser->role->name);

            $user->notify(new NewOrder($user->firsName, $totalHours, $request->hours));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            abort('500');
        }

        return redirect()->back()->with([
            'success' => 'Orden creada correctamente'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('orders.edit')->with([
            'order' => $order,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrder $request, Order $order)
    {
        DB::beginTransaction();
        try {
            $order->folio = $request->folio;
            $user = User::find($order->paquete_users->users->id);

            //Actual Order Hours
            $hours_a = $request->hours;
            //Previous Order Hours
            $hours_p = $request->previousHours;

            if ($hours_a <= $order->paquete_users->paquete->total_hours) {
                if ($hours_a == $hours_p || $hours_a < $hours_p) {
                    $order->hours = $hours_a;
                } else
            if ($hours_a > $hours_p) {
                    //Diference between the two hours
                    $hours_d = $hours_a - $hours_p;
                    //If the difference between the two hours is bigger than the package hours  we gonna return a error
                    if (!self::validateHours($order->paquete_users, $hours_d)) {
                        return redirect()->back()->with([
                            'error' => 'Ese paquete no cuenta con horas necesarias'
                        ]);
                    }
                    $order->hours = $hours_a;
                }
            } else {
                return redirect()->back()->with([
                    'error' => 'Ese paquete no cuenta con horas necesarias'
                ]);
            }

            $order->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            abort('500');
        }
        return redirect()->back()->with([
            'success' => 'Orden editada correctamente'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //return $order->paquete_users->users->ActivePackage->first();
        DB::beginTransaction();
        try
        {
            $actualUser = Auth::user();
            $log = new AppLog();
            $log->user()->associate($actualUser);
            $log->entity()->associate($actualUser->entity);
            $log->message = "Eliminación permanente de orden";

            $log->save();
            //Case 1 The user don't have hours 
            //if($order->paquete_users->users->ActivePackage->first() == NULL)
            //{
            $order->delete();
            Log::info("Delete -> id: $order->id user:$actualUser->id role: " . $actualUser->role->name);
            DB::commit();
            //}
            //else
            //{
                
            //    return $order->paquete_users->users->ActivePackage->first();
            //}
            //Case 2 The package of the order is not the same as actual or tha package is the same
            //return $order->paquete_users->users->ActivePackage->first()->HoursLeftValue();
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            Log::error($e);
            abort('500');
        }       
        return redirect()->route('orders.index')->with([
            'success' => 'Orden eliminada correctamente'
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function validateHours($paqueteUser, $hours)
    {
        try {
            $invalid = true;
            $a = $paqueteUser->HoursLeftValue;
            $b = $paqueteUser->paquete->total_hours;
            if ($paqueteUser->HoursLeftValue < $hours) {
                $invalid = false;
            }
        } catch (\Exception $ex) {
            Log::error($ex);
        }
        return $invalid;
    }
}
