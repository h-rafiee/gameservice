<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table='games';

    protected $fillable = [
        'category_id', 'publisher_id', 'package_name',
        'title','logo','download_count','previews','description',
        'params'
    ];

    public function category(){
        return $this->belongsTo('App\Category','category_id');
    }

    public function achievements(){
        return $this->hasMany('App\GameAchievement','game_id');
    }

    public function items(){
        return $this->hasMany('App\GameItem','game_id');
    }

    public function oauth(){
        return $this->belongsToMany('App\oAuthClient','oauth_game_client','game_id');
    }
}
