<?php

namespace App\Http\Middleware;

use DB;
use Closure;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class LoginGate
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
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $tokenCache = new \App\TokenStore\TokenCache;
        $graph = new Graph();
        if($tokenCache->getAccessToken() == ''){
            return redirect()->route('greeting');
        }else{
            $graph->setAccessToken($tokenCache->getAccessToken());
            $user = $graph->createRequest('GET', '/me')
                ->setReturnType(Model\User::class)
                ->execute();
            if(DB::table('users')->where('email', '=', $user->getUserPrincipalName())->where('admin', 1)->exists()){
                view()->share(['admin' => 1]);
            }
            return $next($request);
        }
    }
}
