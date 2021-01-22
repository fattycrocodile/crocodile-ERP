<?php

namespace App\Http\Controllers\Accounting\Accounting\Accounting\Accounting\Accounting\Commercial\Commercial\Commercial\Commercial\Config\Config\Config\Crm\Crm\Crm\Crm\Crm\Crm\Crm\Hr\Hr\Hr\Hr\Hr\Hr\Hr\Inventory\Inventory\Auth;

use App\Http\Controllers\Accounting\Accounting\Accounting\Accounting\Accounting\Commercial\Commercial\Commercial\Commercial\Config\Config\Config\Crm\Crm\Crm\Crm\Crm\Crm\Crm\Hr\Hr\Hr\Hr\Hr\Hr\Hr\Inventory\Inventory\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
}
