<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
