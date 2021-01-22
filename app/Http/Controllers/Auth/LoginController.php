<?php

namespace App\Http\Controllers\Accounting\Accounting\Accounting\Accounting\Accounting\Commercial\Commercial\Commercial\Commercial\Config\Config\Config\Crm\Crm\Crm\Crm\Crm\Crm\Crm\Hr\Hr\Hr\Hr\Hr\Hr\Hr\Inventory\Inventory\Auth;

use App\Http\Controllers\Accounting\Accounting\Accounting\Accounting\Accounting\Commercial\Commercial\Commercial\Commercial\Config\Config\Config\Crm\Crm\Crm\Crm\Crm\Crm\Crm\Hr\Hr\Hr\Hr\Hr\Hr\Hr\Inventory\Inventory\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
