<?php

namespace App\Http\Controllers;

use App\Paquete;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        //middleware ('config') deleted
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $clients = User::where('role_id', 3)->get();
        $packages = Paquete::all();
        if (Auth::user()->role->id == 3) {
            return view('cliente.show')->with('user', Auth::user());
        }
        return view('home')->with([
            'clients' => $clients,
            'packages' => $packages,
            'viewId' => 0
        ]);;
    }
}
