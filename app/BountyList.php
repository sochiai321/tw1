<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BountyList extends Model
{
    protected $table = 'bounty_list';
    protected $fillable =   [   'bounty_username',
    							'twitter_account_uid',
                                'bounty_uid',
                                'number_of_retweet',
                                'number_of_tweet',
                                'tweet_keyword',
                                'number_of_tweet_with_quote',
                                'tweet_with_quote_keyword',
                                'comment_enabled'
                            ];
}
