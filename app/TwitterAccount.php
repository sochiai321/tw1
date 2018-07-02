<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwitterAccount extends Model
{
    protected $table = 'twitter_account';
    protected $fillable = array('twitter_uid', 'userID', 'Access_Token', 'twitter_username', 'isActive', 'isDisable', 'Access_Token_Secret', 'profile_image_url');
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
