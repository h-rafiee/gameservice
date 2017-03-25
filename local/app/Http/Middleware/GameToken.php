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
                $device = \App\GameToken::with(['game','user'])->where('token',$token[1])->where('expire_datetime','>',date("Y-m-d H:i:s"))->first();
                if(empty($device)){
                    $data['status']='fail';
                    $data['message']='Authorization token not valid.';
                    return response(json_encode($data),500);
                }
                $request->device = $device;
                return $next($request);
                break;
            case "refresh":
                $device = \App\GameToken::with(['game','user'])->where('refresh_token',$token[1])->first();
                if(empty($device)){
                    $data['status']='fail';
                    $data['message']='Authorization token not valid.';
                    return response(json_encode($data),500);
                }
                $helper = new \App\Helpers\Helper();
                $game = \App\Game::find($device->game_id);
                $device->token = $data['session'] = hash('md4',$helper->generateRandomString(5).'Z'.$game->app_key.'X'.time());
                $device->expire_datetime = date("Y-m-d H:i:s",strtotime("10 days",time()));
                $device->save();
                $request->device = $device;
                return $next($request);
                break;
            default:
                abort(502);
        }
        abort(404);
    }
}
