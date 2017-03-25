<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGame extends Model
{
    protected $table = 'user_games';

    protected $fillable = [
        'user_id', 'game_id', 'last_time_active','params'
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
        return $this->hasMany('App\UserGameAchievement','user_game_id');
    }

    public function items(){
        return $this->hasMany('App\UserGameItem','user_game_id');
    }
}
