<?php

namespace App\Http\Controllers\Auth;

use App\Admin;
use App\Block;
use App\Http\Controllers\Controller;
use App\User;
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
        return redirect('homepage');
    }

    public function showLoginForm()
    {
        session(['link' => url()->previous()]);
        return view('auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        $user = User::find(Auth::id());
        if ($user->blocked) {
            $block = Block::where('id_user', Auth::id())->orderBy('end_date', 'desc')->first();
            Auth::logout();
            return back()->withErrors(['email' => ["This account is blocked until " . $block->end_date . "."]]);
        }
        if(session(urlencode('link')) == null)
            return redirect('/homepage');
        return redirect(session('link'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return back();
    }
}
