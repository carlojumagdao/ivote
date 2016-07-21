<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use DB;
use App\active AS active;
class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('auth/login');
            }
        }
        if (Auth::user()->blDelete){
            return redirect()->guest('auth/logout');
        }
        session(['name' => Auth::user()->name, 'email' => Auth::user()->email, 'picname' => Auth::user()->txtPath,
            'id' => Auth::user()->id, 'admin' => Auth::user()->blAdmin, 'password' => Auth::user()->password]);
         $name = session('name');
        
        DB::table('tblactiveuser')
            ->where('tblactiveuserID',1)
            ->update(
                ['name' => $name] 
            );
        //  $active = active::find(1);
        // // if($active) $name = $active->name;
        // // else $name = 'skin-blue';
        // // $ui = ui::find(1);
        
        // if($active)
        // {            
        //     $active->name = $request->session('name');
        // }
        // else{
        //     $active = new active();
        //     $active->name = $request->session('name');
        // }
        return $next($request);
    }
}
