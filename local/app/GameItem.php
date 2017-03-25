<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameItem extends Model
{
    protected $table = 'game_items';

    protected $fillable = [
        'game_id','slug','title',
        'description','price','free_item','logo',
        'type'
    ];

    public function game(){
        return $this->belongsTo('App\Game','game_id');
    }

    public function users(){
        return $this->belongsToMany('App\User','user_game_items','game_item_id');
    }

    public function user_items_used(){
        return $this->hasMany('App\UserGameItem','game_item_id')->where('used',1);
    }
}
