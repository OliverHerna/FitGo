<?php

namespace App\View\Components;

use App\Paquete;
use App\User;
use Illuminate\View\Component;

class asingPackage extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    { }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $clients = User::where('role_id', 3)->get();
        $packages = Paquete::all();
        return view('components.asing-package')->with([
            'clients' => $clients,
            'packages' => $packages,
        ]);
    }
}