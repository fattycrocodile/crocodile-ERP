<?php

namespace App\Http\Controllers;

use App\Modules\Crm\Models\Invoice;
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
        $invoice = Invoice::orderBy('date', 'desc')->take(5)->get();

        $this->setPageTitle('Dashboard', 'Admin Dashboard');
        return view('home', compact('invoice'));
    }
}
