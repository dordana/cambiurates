<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthRequest;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = 'admin';
    protected $redirectAfterLogout = 'admin';

    protected $loginView = 'admin.auth.login';
    protected $resetView = 'admin.auth.password.reset';
    protected $registerView = 'admin.auth.register';

    /**
     * Create a new authentication controller instance.
     *
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'register', 'update', 'showRegistrationForm', 'confirm']]);
    }

    /**
     * @param AuthRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Foundation\Validation\ValidationException
     */
    public function register(AuthRequest $request)
    {
        $request->offsetSet('password', bcrypt($request->get('password')));

        User::create($request->all());

        return redirect('admin/users')->with(['success' => 'User successfully created!']);
    }

    /**
     * @param AuthRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AuthRequest $request)
    {
        $oUser = User::find($request->get('id'));

        if (!$oUser) {
            return redirect()->back()->with(['not_found' => 'Sorry, we couldn\'t find that record.']);
        }

        $request->offsetSet('password', bcrypt($request->get('password')));

        $oUser->update($request->all());

        return redirect('admin/users')->with(['success' => 'User successfully updated!']);
    }

    public function confirm(Request $request)
    {

        $user = Auth::user();
        $valid = ($user->confirmation_code === $request->get('confirmation_code'));
        if ($valid) {

            if ($user->confirmed === 0) {
                $user->confirmed = 1;
                $user->save();
            }

            return redirect('admin');
        } else {
            return redirect()->route('getConfirm')->with(['confirmation_code' => 'Wrong code! Please check your email for confirmation code again.']);
        }
    }

    public function authenticate(Request $request)
    {

        $throttles = $this->isUsingThrottlesLoginsTrait();
        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $remember = ($request->input('remember') == 'on') ? true : false;

        $auth = Auth::attempt(
            [
                'email'             => $request->input('email'),
                'password'          => $request->input('password'),
            ], $remember
        );

        if (!$auth) {

            if ($throttles) {
                $this->incrementLoginAttempts($request);
            }

            return redirect()->back();
        }

        //Update the confirmation code
        User::where(['email' => $request->input('email')])->first()->deliverConfirmationCode();
        User::where(['email' => $request->input('email')])->update(['confirmed' => 0]);

        return view(
            'admin.auth.confirm',
            [
                'message'  => 'Thanks for logging in. Please check your email for confirmation code!',
            ]
        );
    }
}
