<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameLeaderboard extends Model
{
    protected $table='game_leaderboards';

    protected $fillable = [
        'game_id','slug', 'title', 'logo',
        'description','params'
    ];

    public function game(){
        return $this->belongsTo('App\Game','game_id');
    }

    public function users(){
        return $this->belongsToMany('App\User','user_game_leaderboards','game_leaderboard_id');
    }
}
