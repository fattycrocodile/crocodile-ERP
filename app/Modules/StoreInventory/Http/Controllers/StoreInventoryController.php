<?php

namespace App\Modules\StoreInventory\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreInventoryController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("StoreInventory::welcome");
    }
}
