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
use Socialite;

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


    public function redirectToProvider($provider){
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from the provider
     * 
     * @return Response
     */
    public function handleProviderCallback($provider){
        $user = Socialite::driver($provider)->stateless()->user();
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        //return $user->id;
        return redirect($this->redirectTo);
    }

    public function findOrCreateUser($user, $provider){
        $authUser = User::where('provider_id', $user->id)->first();
        if($authUser){
            return $authUser;
        }
        return User::create([
            'name' => $user->name,
            'email' => $user->email,
            'provider' => strtoupper($provider),
            'provider_id' => $user->id
        ]);
    }
}
