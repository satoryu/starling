<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwitterAccount extends Model
{
    protected $fillable = ['profile_image_url', 'screen_name', 'twitter_id', 'token', 'token_secret'];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
