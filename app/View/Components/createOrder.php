<?php

namespace App\View\Components;

use App\PaqueteUser;
use App\User;
use Illuminate\View\Component;

class createOrder extends Component
{
    public $viewId;
    public $users;
    public $clientProfile;
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public function __construct($viewId, $user)
    {
        $this->viewId = $viewId;
        $this->clientProfile = User::where('id', $user);
        $this->users = User::has('paquete_user')->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.create-order');
    }
}
