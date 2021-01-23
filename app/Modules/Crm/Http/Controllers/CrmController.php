<?php

namespace App\Modules\Crm\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CrmController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("Crm::welcome");
    }
}
