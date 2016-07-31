<?php

namespace App\Http\Middleware;
use Closure;
use DB;
use Illuminate\Http\Response;

class OAuth{
    public function handle($request, Closure $next){
        if(!$request->has('_clientID') OR !$request->has('_clientSecret')){
            return (new Response([
                'error'=>true,
                'message'=>'App OAuth _clientID Or _clientSecret not found.'
            ],400))
                ->header('Content-Type','application/json');
        }
        $checkAppSecret=DB::table('app_registration')->where('appID',$request->_clientID)->where('appSecret',$request->_clientSecret)->count();
        if(!$checkAppSecret){
            return (new Response([
                '_error'=>true,
                '_message'=>'App OAuth Failed.'
            ],403))
                ->header('Content-Type','application/json');
        }


        return $next($request);
    }
}