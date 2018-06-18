<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';

    // Relación 1:N
    public function comments(){
        return $this->hasMany('App\Comment')->orderBy('id','desc');
        // hasOne
    }

    // Relación N:1
    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

}