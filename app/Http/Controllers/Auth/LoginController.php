<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
    protected $redirectTo = '/wastes';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'name';
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->ability(['super-admin'], ['create-manager'])) {
            return redirect()->route('auth.manager.news.index');
        }
        if ($user->ability(['manager-waste'], ['create-manager'])) {
            return redirect()->route('auth.managerwaste.wastes.index');
        }
        if ($user->ability(['manager'], ['create-manager'])) {
            return redirect()->route('auth.manager.news.index');
        }
        return redirect('/');
    }
}
