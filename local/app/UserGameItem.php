<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGameItem extends Model
{
    protected $table = 'user_game_items';

    protected $fillable = [
        'user_game_id', 'game_item_id','used'
    ];

    public function user_game(){
        return $this->belongsTo('App\UserGame','user_game_id');
    }

    public function shop_items(){
        return $this->belongsTo('App\ShopItem','game_item_id');
    }
}
