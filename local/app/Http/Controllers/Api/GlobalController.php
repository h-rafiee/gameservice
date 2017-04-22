<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GlobalController extends Controller
{
    public function access(Request $request){
        $game = \App\Game::where('api_key',$request->header('key'))->first();
        if(empty($game)){
            abort(404);
        }
        $helper = new \App\Helpers\Helper();
        $device = \App\GameToken::where('game_id',$game->id)->where('imei',$request->imei)->first();
        if(!empty($device)){
            $device->token = hash('md4',$helper->generateRandomString(5).'Z'.$game->app_key.'X'.time());
            $device->refresh_token = hash('md4',time().'X'.$game->app_key.'Z'.$helper->generateRandomString(6));
            $device->expire_datetime =  date("Y-m-d H:i:s",strtotime("10 days",time()));
            $device->save();
        }else{
            $device = new \App\GameToken();
            $device->game_id = $game->id;
            $device->imei = $request->imei;
            $device->token = hash('md4',$helper->generateRandomString(5).'Z'.$game->app_key.'X'.time());
            $device->refresh_token = hash('md4',time().'X'.$game->app_key.'Z'.$helper->generateRandomString(6));
            $device->expire_datetime =  date("Y-m-d H:i:s",strtotime("10 days",time()));
            $device->params = $request->params;
            $device->save();
        }
        return response()->json(\App\GameToken::find($device->id));
    }

    public function refresh(Request $request){
        $device = \App\GameToken::with(['game','user'])->where('refresh_token',$request->header('key'))->first();
        if(empty($device)){
            $data['status']='fail';
            $data['message']='Authorization token not valid.';
            return response(json_encode($data),444);
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
            return response(json_encode($data),444);
        }
        if($request->device->user_id == NULL){
            $data['message']='user must be login,not valid request';
            return response(json_encode($data),444);
        }
        $request->device->user_id = null;
        $request->device->save();
        $data['status']='done';
        $data['message']='user logout';
        return response()->json($data);
    }

    public function upload_request(Request $request){
        $username = $request->username;
        $api_key = $request->api_key;
        $game = \App\Game::where('api_key',$api_key)->first();
        $user = \App\User::where('username',$username)->first();
        if(empty($game) || empty($user)){
            $data['status']='fail';
            $data['message']='Request not valid';
            return response(json_encode($data),444);
        }
        $upreq = new \App\UploadRequest();
        $upreq->game_id = $game->id;
        $upreq->user_id = $user->id;
        $helper = new \App\Helpers\Helper();
        $upreq->access = $helper->generateRandomString(20);
        $upreq->expired_time =  date("Y-m-d H:i:s",strtotime("20 minutes",time()));
        $upreq->save();
        $data['status']='done';
        $data['upload_request']=$upreq;
        return response()->json($data);


    }
}
