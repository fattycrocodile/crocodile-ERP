<?php

namespace App\Modules\Hr\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HrController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("Hr::welcome");
    }
}
