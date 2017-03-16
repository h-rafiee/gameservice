<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameAchievement extends Model
{
    protected $table='game_achievements';

    protected $fillable = [
        'game_id','slug', 'title', 'logo',
        'description','params','script'
    ];

    public function game(){
        return $this->belongsTo('App\Game','game_id');
    }

    public function users(){
        return $this->belongsToMany('App\User','user_game_achievements','game_achievement_id');
    }
}
