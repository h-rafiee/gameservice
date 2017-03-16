<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use HasApiTokens, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','username','userID', 'email', 'password',
        'mobile','about'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password','userID','remember_token',
    ];


    public function games(){
        return $this->hasMany('App\UserGame','user_id');
    }

    public function achievements(){
        return $this->belongsToMany('App\GameAchievement','user_game_achievements','user_id');
    }

    public function items(){
        return $this->belongsToMany('App\ShopItem','user_game_items','user_id');
    }

    public function game_items(){
        return $this->hasMany('App\UserGameItem','user_id');
    }

}
