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
        $device->imei = $request->imei;
        $device->token = hash('md4',$helper->generateRandomString(5).'Z'.$game->app_key.'X'.time());
        $device->refresh_token = hash('md4',time().'X'.$game->app_key.'Z'.$helper->generateRandomString(6));
        $device->expire_datetime =  date("Y-m-d H:i:s",strtotime("10 days",time()));
        $device->params = $request->params;
        $device->save();
        return response()->json(\App\GameToken::find($device->id));
    }

    public function refresh(Request $request){
        $device = \App\GameToken::with(['game','user'])->where('refresh_token',$request->header('refresh_token'))->first();
        if(empty($device)){
            $data['status']='fail';
            $data['message']='Authorization token not valid.';
            return response(json_encode($data),500);
        }
        $helper = new \App\Helpers\Helper();
        $game = \App\Game::find($device->game_id);
        $device->token = $data['session'] = hash('md4',$helper->generateRandomString(5).'Z'.$game->app_key.'X'.time());
        $device->expire_datetime = date("Y-m-d H:i:s",strtotime("10 days",time()));
        $device->refresh_token = hash('md4',time().'X'.$game->app_key.'Z'.$helper->generateRandomString(6));
        $device->save();
        return response()->json(\App\GameToken::find($device->id));

    }

    public function logout(Request $request){
        $data['status'] = 'fail';
        if($request->device->imei != $request->imei){
            $data['message']='Request not valid';
            return response(json_encode($data),500);
        }
        if($request->device->user_id == NULL){
            $data['message']='user must be login,not valid request';
            return response(json_encode($data),500);
        }
        $request->device->user_id = null;
        $request->device->save();
        $data['status']='done';
        $data['message']='user logout';
        return response()->json($data);
    }
}
