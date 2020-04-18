<?php

namespace App\Http\Controllers\Auth;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

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
    protected $redirectTo = '/homepage';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:seller')->except('logout');
    }

    public function getUser()
    {
        return $request->user();
    }

    public function home()
    {
        return redirect('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user_id = DB::table('admins')->where('email', $request->email)->first()->id;

        if ($user_id != null) {
            if (Auth::guard('admin')->attempt($credentials)) {
                // Authentication passed...
                return redirect()->intended('dashboard');
            }
            else {
                $user_id = DB::table('users')->where('email', $request->email)->first()->id;
                $found = DB::table('sellers')->where('id', $user_id)->first()->id;
                if($found != null) {
                    if (Auth::guard('seller')->attempt($credentials)) {
                        // Authentication passed...
                        return redirect()->intended('dashboard');
                    }
                }
                else {
                    Auth::guard('user')->attempt($credentials);
                }
            }
        }
    }
}
