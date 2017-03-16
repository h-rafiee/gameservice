<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table='categories';

    protected $fillable = [
        'title', 'params', 'parent_id',
    ];

    public function games(){
        return $this->hasMany('App\Game','category_id');
    }
}
