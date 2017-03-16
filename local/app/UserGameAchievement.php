<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGameAchievement extends Model
{
    protected $table = 'user_game_achievements';

    protected $fillable = [
        'user_game_id', 'game_achievement_id',
    ];

    public function user_game(){
        return $this->belongsTo('App\UserGame','user_game_id');
    }

    public function game_achievement(){
        return $this->belongsTo('App\GameAchievement','game_achievement_id');
    }
}
