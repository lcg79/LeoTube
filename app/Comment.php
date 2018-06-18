<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    // Relación N:1
    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    // Relación N:1
    public function video() {
        return $this->belongsTo('App\Video', 'video_id');
    }
    
}
