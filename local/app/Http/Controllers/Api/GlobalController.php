<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GlobalController extends Controller
{
    public function access(Request $request){
        $game = \App\Game::where('api_key',$request->header('key'))->first();
        if(empty($game)){
            abort(402);
        }
        $helper = new \App\Helpers\Helper();
        $device = new \App\GameToken();
        $device->game_id = $game->id;
        $device->token = hash('md4',$helper->generateRandomString(5).'Z'.$game->app_key.'X'.time());
        $device->refresh_token = hash('md4',time().'X'.$game->app_key.'Z'.$helper->generateRandomString(6));
        $device->expire_datetime =  date("Y-m-d H:i:s",strtotime("10 days",time()));
        $device->params = $request->params;
        $device->save();
        return response()->json(\App\GameToken::find($device->id));
    }
}
