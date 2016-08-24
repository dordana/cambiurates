<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;

class PasswordController extends Controller
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

    protected $redirectTo = 'admin';
    protected $linkRequestView = 'admin.auth.passwords.email';
    protected $resetView = 'admin.auth.passwords.reset';

    /**
     * Create a new password controller instance.
     *
     * PasswordController constructor.
     */
    public function __construct()
    {

        $this->middleware('guest');
    }
}
