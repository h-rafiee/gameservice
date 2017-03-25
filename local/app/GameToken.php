<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameToken extends Model
{
    protected $table = 'game_devices_session';

    protected $hidden = [
        'id','game_id','user_id','params',
    ];

    public function game(){
        return $this->belongsTo('\App\Game','game_id');
    }

    public function user(){
        return $this->belongsTo('\App\User','user_id');
    }
}
