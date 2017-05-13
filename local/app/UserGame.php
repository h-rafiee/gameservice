<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGame extends Model
{
    protected $table = 'user_games';

    protected $fillable = [
        'user_id', 'game_id', 'last_time_active','profile_pic','params'
    ];

    protected $hidden = [
        'id','game_id','user_id','last_time_active'
    ];

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function game(){
        return $this->belongsTo('App\Game','game_id');
    }

    public function achievements(){
        return $this->belongsToMany('App\GameAchievement','user_game_achievements','user_game_id','game_achievement_id');
    }

    public function items(){
        return $this->belongsToMany('App\GameItem','user_game_items','user_game_id','game_item_id');
    }

    public function leaderboards(){
        return $this->hasMany('App\UserGameLeaderboard','user_game_id');
    }
}
