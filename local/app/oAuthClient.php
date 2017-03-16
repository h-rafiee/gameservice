<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class oAuthClient extends Model
{
    protected $table = 'oauth_clients';

    public function games(){
        return $this->belongsToMany('App\oAuthClient','oauth_game_client','client_id');
    }
}
