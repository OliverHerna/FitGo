<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Scheadule extends Controller
{
    public function calendar()
    {
        return view('scheduled.calendar');

    }
}
