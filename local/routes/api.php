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
    Route::post('get_access_refresh','GlobalController@refresh');
    Route::post('get_upload_access','GlobalController@upload_request');

    Route::post('user_game_profile/{access}',function(Request $request,$access){
        $upload_request = \App\UploadRequest::where('access',$access)->where('uploaded',0)->where('expired_time','>',date("Y-m-d H:i:s"))->first();
        $data['status'] = 'fail';
        if(empty($upload_request)){
            $data['message']='Request not valid!';
            return response(json_encode($data),444);
        }
        $user_game = \App\UserGame::where('game_id',$upload_request->game_id)
            ->where('user_id',$upload_request->user_id)
            ->first();

        $path = '';

        if($request->hasFile('profile_pic')){
            $path = $request->profile_pic->store('images', 'uploads');
        }
        if(empty($path)){
            $data['message']='error on upload';
            return response(json_encode($data),444);
        }
        $user_game->profile_pic = $path;
        $user_game->save();
        $upload_request->uploaded=1;
        $upload_request->save();
        $data['status']='done';
        $data['message']='profile picture added to user';
        return response()->json($data);
    });


    Route::group(['middleware'=>'game_token'],function(){

        Route::post('logout','GlobalController@logout');


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
                return response(json_encode($data),444);
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
            return response(json_encode($data),444);
        });

        Route::post('sign_up',function(Request $request){
            $data['status'] = 'fail';
            $user_exist = \App\User::where('username',$request->username)
                ->count();
            if($user_exist>0){
                $data['message'] = 'Username exist!';
                return response(json_encode($data),444);
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


        Route::get('user',function(Request $request){
            $data['status'] = 'fail';
            if($request->device->user_id == NULL){
                $data['message']='user must be login,not valid request';
                return response(json_encode($data),444);
            }
            $user = \App\User::find($request->device->user_id);
            $data['status']='done';
            $data['user']=$user;
            return response()->json($data);
        });

        Route::post('user_edit',function(Request $request){
            $data['status'] = 'fail';
            if($request->device->user_id == NULL){
                $data['message']='user must be login,not valid request';
                return response(json_encode($data),444);
            }
            $user = \App\User::find($request->device->user_id);
            if( $user->username != $request->username && \App\User::where('username',$request->username)->count()>0){
                $data['message']='Username exist';
                return response(json_encode($data),444);
            }

            if( $user->mobile != $request->mobile && \App\User::where('mobile',$request->mobile)->count()>0){
                $data['message']='Mobile exist';
                return response(json_encode($data),444);
            }
            $user->username = $request->username;
            $user->mobile = $request->mobile;
            $user->name = $request->name;
            if(!empty($request->password)){
                $user->password =  Hash::make($request->password);
            }
            $user->save();
            $data['status']='done';
            $data['message']='User edited';
            return response()->json($data);
        });

        Route::post('set_user_game_info',function(Request $request){
            $data['status'] = 'fail';
            if($request->device->user_id == NULL){
                $data['message']='user must be login,not valid request';
                return response(json_encode($data),444);
            }
            $user_game = \App\UserGame::with(['items','achievements'])
                ->where('game_id',$request->device->game_id)
                ->where('user_id',$request->device->user_id)
                ->first();
            $user_game->params = $request->params;
            $user_game->save();
            $data['status']='done';
            $data['message']='User game data updated';
            $data['user_game']=$user_game;
            return response()->json($data);
        });

        Route::get('user_game_info',function(Request $request){
            $data['status'] = 'fail';
            if($request->device->user_id == NULL){
                $data['message']='user must be login,not valid request';
                return response(json_encode($data),444);
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
            if($request->device->user_id == NULL){
                $data['message']='user must be login,not valid request';
                return response(json_encode($data),444);
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
            if($request->device->user_id == NULL){
                $data['message']='user must be login,not valid request';
                return response(json_encode($data),444);
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

        Route::post('update_score_user',function(Request $request){
            $data['status'] = 'fail';
            if($request->device->user_id == NULL){
                $data['message']='user must be login,not valid request';
                return response(json_encode($data),444);
            }
            $user_game = \App\UserGame::where('game_id',$request->device->game_id)
                ->where('user_id',$request->device->user_id)
                ->first();
            $game_leaderboard = \App\GameLeaderboard::where('slug',$request->leaderboard_slug)->first();
            $score = \App\UserGameLeaderboard::updateOrCreate(
                ['user_game_id'=>$user_game->id , 'game_leaderboard_id' => $game_leaderboard->id ],
                ['score' => $request->score]
            );
            $data['status']='done';
            $data['message']='score updated for user';
            return response()->json($data);
        });

        Route::get('list_leaderboards_game',function(Request $request){
            $game_leaderboard = \App\GameLeaderboard::where('game_id',$request->device->game_id)->get();
            $data['status']='done';
            $data['leaderboards']  = $game_leaderboard;
            return response()->json($data);
        });

        Route::get('leaderboard/{slug}',function(Request $request,$slug){
            $data['status']='fail';
            $game_leaderboard = \App\GameLeaderboard::where('slug',$slug)->first();
            if(empty($game_leaderboard)){
                $data['message']='leaderbaord not exist';
                return response(json_encode($data),444);
            }
            $leaderbaord = \App\UserGameLeaderboard::get_rank_list($game_leaderboard->id);
            $current_user = null;
            if($request->device->user_id != NULL)
                $current_user = \App\UserGameLeaderboard::get_user_rank($game_leaderboard->id,$request->device->user_id);
            $data['status']='done';
            $data['current_user_rank'] = $current_user;
            $data['leaderboard']=$leaderbaord;
            return response()->json($data);
        });

        Route::post('add_order_user',function(Request $request){

        });
    });
});
