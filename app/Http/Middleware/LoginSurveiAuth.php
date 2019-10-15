<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\UserBranch;

class LoginSurveiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $data = UserBranch::where('id',Auth::user()->id)->first();
        $ip_local = $this->get_client_ip();
        $login = array($ip_local,$data->token);
        $verify = join('',$login);
        if(md5($verify) != $data->ip_address){
            Auth::logout();
            return redirect('/client');
        }

        return $next($request);
    }

    private function get_client_ip() {
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
