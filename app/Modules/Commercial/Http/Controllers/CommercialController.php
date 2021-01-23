<?php

namespace App\Modules\Commercial\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommercialController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("Commercial::welcome");
    }
}
