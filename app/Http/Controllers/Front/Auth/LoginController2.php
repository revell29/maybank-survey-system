<?php

namespace App\Http\Controllers\Front\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Adldap\Laravel\Facades\Adldap;
use Validator;
use Auth;
use App\Models\User;
use App\Models\UserBranch;

class LoginController2 extends Controller
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
    protected $redirectTo = '/client/home';
    protected $guard = 'user_branch';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:user_branch')->except('logout');
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
        return \request('guard') == 'user_branch' ? 'username' : 'username';
    }

    protected function authenticated(Request $request, $user)
    {
        return response()->json([
            'success' => true,
            'redirect' => url($this->redirectTo)
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('user_branch')->logout();
        return response()->json([
            'success' => true,
            'redirect' => url('/client')
        ]);
    }

    /**
     * define function login for survei system
     * 
     * return @void
     */
    public function attemptLogin(Request $request)
    {
        $this->validate($request, [
            'username'   => 'required',
            'password' => 'required|min:6'
        ]);

        $user = UserBranch::where('username',$request->username)->first();
        if($user){
            
            $getClientIp = $this->get_client_ip(); // get ip client
            $getToken = $this->token(10); // get random token
            $getAuthToken = join('',array($getClientIp,$getToken)); //combine ip and token for authentication

            // checking if ip and token null
            if(is_null($user->ip_address) && is_null($user->token)){
                $user->update([
                    'ip_address' => md5($getAuthToken),
                    'token' => $getToken,
                    'ip_address2' => $getClientIp,
                    'password' => bcrypt($request->password)
                ]);

                $user_format = env('LDAP_USER_FORMAT','cn=%s,'.env('LDAP_BASE_DN',''));
                $userdn = sprintf($user_format,$request->username);
        
                if(Adldap::auth()->attempt($request->username,$request->password)){
                    $credentials = $request->only('username','password');
                    Auth::guard('user_branch')->attempt($credentials);
                    return response()->json([
                        'success' => true,
                        'redirect' => $this->redirectTo
                    ],200);
                } else {
                    return response()->json(['message' => 'Incorrect username or password'],401);
                }
                
            } else {

                $user = UserBranch::where('username',$request->username)->first();
                $getClientIp = $this->get_client_ip(); // get ip client
                $getToken = $user->token; // get random token
                $getAuthToken = join('',array($getClientIp,$getToken)); //combine ip and token for authentication

                if(md5($getAuthToken) == $user->ip_address){
                    $user_format = env('LDAP_USER_FORMAT','cn=%s,'.env('LDAP_BASE_DN',''));
                    $userdn = sprintf($user_format,$request->username);
                    if(Adldap::auth()->attempt($request->username,$request->password)){
                        $credentials = $request->only('username','password');
                        Auth::guard('user_branch')->attempt(['username' => $request->username,'password' => $request->password]);
                        return response()->json([
                            'success' => true,
                            'redirect' => $this->redirectTo
                        ],200);
                    } else {
                        return response()->json(['message' => 'Incorrect username or password'],401);
                    }
                } else {
                    return response()->json([
                        "message" => "yout can't login in other devices" 
                    ],401);
                }
                
            }

        } else {
            return response()->json(['message' => 'Username not found'],401);
        }
        
    }

    private function token($length = 10) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function get_client_ip() {
           // Get real visitor IP behind CloudFlare network
           if ( !empty( $_SERVER['HTTP_CLIENT_IP'] ) )
           {
             $ip = $_SERVER['HTTP_CLIENT_IP'];
           }
           elseif( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) )
           //to check ip passed from proxy
           {
             $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
           }
           else
           {
             $ip = $_SERVER['REMOTE_ADDR'];
           }
           return $ip;
    }

}
