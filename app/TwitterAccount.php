<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterAccount extends Model
{
    protected $fillable = ['profile_image_url', 'screen_name', 'twitter_id', 'token', 'token_secret'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function tweet($status) {
        $user = $this->user;

        $connection = new TwitterOAuth(
            config('services.twitter.client_id'),
            config('services.twitter.client_secret'),
            $this->token,
            $this->token_secret
        );
        $status = $connection->post('statuses/update', ['status' => $status]);

        return $status;
    }
}
