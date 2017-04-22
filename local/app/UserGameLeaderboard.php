<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserGameLeaderboard extends Model
{
    protected $table = 'user_game_leaderboards';

    protected $fillable = [
        'user_game_id', 'game_leaderboard_id','score'
    ];

    public function user_game(){
        return $this->belongsTo('App\UserGame','user_game_id');
    }

    public function game_leaderboard(){
        return $this->belongsTo('App\GameLeaderboard','game_leaderboard_id');
    }

    public static function get_rank_list($game_leaderboard_id,$limit=10,$offset=0){
        $data = DB::select('
                SELECT t.* , u.username , u.name,u.profile_pic FROM (
                SELECT l.* , @rownum := @rownum + 1 AS rank FROM user_game_leaderboards AS l , (SELECT @rownum := 0) r
                WHERE game_leaderboard_id = :game_leaderboard_id ORDER BY l.score DESC
                ) AS t
                JOIN user_games AS ug ON ug.id = t.user_game_id
                JOIN users as u ON u.id = ug.user_id
                LIMIT :limit OFFSET :offset
         ',['game_leaderboard_id'=>$game_leaderboard_id,'limit'=>$limit,'offset'=>$offset]);
        return $data;
    }
    public static function get_user_rank($game_leaderboard_id , $user_id){
        $data = DB::select('
                SELECT t.* , u.id , u.username , u.name,u.profile_pic FROM (
                SELECT l.* , @rownum := @rownum + 1 AS rank FROM user_game_leaderboards AS l , (SELECT @rownum := 0) r
                WHERE game_leaderboard_id = :game_leaderboard_id ORDER BY l.score DESC
                ) AS t
                JOIN user_games AS ug ON ug.id = t.user_game_id
                JOIN users as u ON u.id = ug.user_id
                WHERE u.id = :user_id
                LIMIT 1 OFFSET 0
         ',['game_leaderboard_id'=>$game_leaderboard_id,'user_id'=>$user_id]);
        return $data;
    }
}
