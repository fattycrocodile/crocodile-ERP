<?php

namespace App\Http\Controllers;

use App\Model\User\User;
use App\Modules\Crm\Models\Invoice;
use App\Modules\StoreInventory\Models\Stores;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $store_id = User::getStoreId(auth()->user()->id);
        if ($store_id > 0) {
            $invoice = Invoice::where('store_id', '=', $store_id)->orderBy('date', 'desc')->take(5)->get();
        } else {
            $invoice = Invoice::orderBy('date', 'desc')->take(5)->get();
        }

        $this->setPageTitle('Dashboard', 'Admin Dashboard');
        return view('home', compact('invoice', 'store_id'));
    }
}
