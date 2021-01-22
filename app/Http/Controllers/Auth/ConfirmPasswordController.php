<?php

namespace App\Http\Controllers\Accounting\Accounting\Accounting\Accounting\Accounting\Commercial\Commercial\Commercial\Commercial\Config\Config\Config\Crm\Crm\Crm\Crm\Crm\Crm\Crm\Hr\Hr\Hr\Hr\Hr\Hr\Hr\Inventory\Inventory\Auth;

use App\Http\Controllers\Accounting\Accounting\Accounting\Accounting\Accounting\Commercial\Commercial\Commercial\Commercial\Config\Config\Config\Crm\Crm\Crm\Crm\Crm\Crm\Crm\Hr\Hr\Hr\Hr\Hr\Hr\Hr\Inventory\Inventory\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ConfirmsPasswords;

class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password confirmations and
    | uses a simple trait to include the behavior. You're free to explore
    | this trait and override any functions that require customization.
    |
    */

    use ConfirmsPasswords;

    /**
     * Where to redirect users when the intended url fails.
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
        $this->middleware('auth');
    }
}
