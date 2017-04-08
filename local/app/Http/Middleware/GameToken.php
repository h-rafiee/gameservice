<?php

namespace App\Http\Middleware;

use Closure;

class GameToken
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
        $token = $request->header('Authorization');
        $token = explode("-",$token);
        $token[0] = strtolower($token[0]);
        switch($token[0]){
            case "token":
                $device = \App\GameToken::with(['game','user'])->where('token',$token[1])->first();
                if(empty($device)){
                    $data['status']='fail';
                    $data['message']='Authorization token not valid.';
                    return response(json_encode($data),444);
                }
                if($device->expire_datetime < date("Y-m-d H:i:s")){
                    $data['status']='fail';
                    $data['message']='Token is expired!';
                    $data['job']='refresh';
                    return response(json_encode($data),444);
                }
                $request->device = $device;
                return $next($request);
                break;
            default:
                abort(400);
        }
        abort(404);
    }
}
