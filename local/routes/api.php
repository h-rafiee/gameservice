<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace'=>'Api'],function() {

    Route::post('get_access','GlobalController@access');

    Route::group(['middleware'=>'game_token'],function(){

        Route::get('achievements',function(Request $request){
            return response()->json(\App\GameAchievement::where('game_id',$request->device->game->id)->get());
        });

        Route::get('items',function(Request $request){
            return response()->json(\App\GameItem::where('game_id',$request->device->game->id)->get());
        });

        Route::get('items/{type}',function(Request $request,$type){
            return response()->json(\App\GameItem::where('game_id',$request->device->game->id)->where('type',$type)->get());
        });

        Route::post('login',function(Request $request){
            $data['status']='fail';
            $user = \App\User::where('username',$request->username)
                ->orWhere('mobile',$request->username)
                ->first();
            if(empty($user)){
                $data['message'] = 'Username/Phone not exist!';
                return response(json_encode($data),500);
            }
            if(Hash::check($request->password,$user->password)){
                $request->device->user_id = $user->id;
                $request->device->save();
                $user->user_game=\App\UserGame::firstOrCreate([
                    'user_id'=>$user->id,
                    'game_id'=>$request->device->game_id
                ]);
                $user->user_game->last_time_active = date("Y-m-d H:i:s");
                $user->user_game->save();

                $data['status']='done';
                $data['message']='welcome';
                $data['user'] = $user;
                return response()->json($data);
            }
            $data['message'] = 'Password not correct!';
            return response(json_encode($data),500);
        });

        Route::post('sign_up',function(Request $request){
            $data['status'] = 'fail';
            $user_exist = \App\User::where('username',$request->username)
                ->count();
            if($user_exist>0){
                $data['message'] = 'Username exist!';
                return response(json_encode($data),500);
            }
            $helper = new \App\Helpers\Helper();
            $userID = $helper->generateNumber(10);
            while(\App\User::where('userID',$userID)->count()>0){
                $userID = $helper->generateNumber(10);
            }
            $password = Hash::make($request->password);
            $user = \App\User::create([
                'name'=>$request->name,
                'username'=>$request->username,
                'mobile'=>$request->mobile,
                'password'=>$password,
                'userID'=>$userID
            ]);

            $data['status']='done';
            $data['message']='sign up completed';
            $data['user']=$user;
            return response()->json($data);
        });

        Route::get('user_game_info',function(Request $request){
            $data['status'] = 'fail';
            if($request->device->user_id != NULL){
                $data['message']='user must be login,not valid request';
                return response(json_encode($data),500);
            }
            $user_game = \App\UserGame::with(['items','achievements'])
                ->where('game_id',$request->device->game_id)
                ->where('user_id',$request->device->user_id)
                ->first();
            $data['status']='done';
            $data['user_game']=$user_game;
            return response()->json($data);
        });

        Route::post('add_item_to_user',function(Request $request){
            $data['status'] = 'fail';
            if($request->device->user_id != NULL){
                $data['message']='user must be login,not valid request';
                return response(json_encode($data),500);
            }
            $user_game = \App\UserGame::where('game_id',$request->device->game_id)
                ->where('user_id',$request->device->user_id)
                ->first();
            \App\UserGameItem::create([
                'user_game_id'=>$user_game->id,
                'game_item_id'=>$request->game_item_id
            ]);
            $data['status']='done';
            $data['message']='item added to user';
            return response()->json($data);
        });

        Route::post('add_achievement_to_user',function(Request $request){
            $data['status'] = 'fail';
            if($request->device->user_id != NULL){
                $data['message']='user must be login,not valid request';
                return response(json_encode($data),500);
            }
            $user_game = \App\UserGame::where('game_id',$request->device->game_id)
                ->where('user_id',$request->device->user_id)
                ->first();
            \App\UserGameAchievement::create([
                'user_game_id'=>$user_game->id,
                'game_achievement_id'=>$request->game_achievement_id
            ]);
            $data['status']='done';
            $data['message']='achievement added to user';
            return response()->json($data);
        });

        Route::post('add_order_user',function(Request $request){

        });
    });
});
