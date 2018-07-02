<?php

namespace App\Http\Services;

use App\Consts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;
use Abraham\TwitterOAuth\TwitterOAuth;
class TwitterService
{

    
    public function MasterTwitterConnect()
    {
        return new TwitterOAuth(Consts::CONSUMER_KEY,Consts::CONSUMER_SECRET,Consts::ACCESS_TOKEN,Consts::ACCESS_TOKEN_SECRET);
    }

    public function getBountyUid($value)
    {
        return $this->MasterTwitterConnect()->get("users/show", ["screen_name" => $value])->id_str;
    }

    public function getUserTimeline($user_id)
    {
        return $this->MasterTwitterConnect()->get('statuses/user_timeline', array('user_id' => $user_id, 'count' => '3'));
    }

    public function getUserTimelineByScreenName($screen_name)
    {
        return $this->MasterTwitterConnect()->get('statuses/user_timeline', array('screen_name' => $screen_name, 'count' => '3'));
    }

    public function getRetweetLink($screen_name, $tweetid)
    {
        return "https://twitter.com/".$screen_name."/status/".$tweetid;
    }

    public function retweetByPostId($connection, $post_id)
    {
        $connection->post('statuses/retweet', array('id' => $post_id));
    }

    public function sendDirectMessage($connection, $user_id, $content)
    {
        $connection->post('direct_messages/new', array('user_id' => $user_id, 'text' => $content));
    }

    public function tweetWithQuote($connection, $content, $link)
    {
        $connection->post('statuses/update', array('status' => $content." ".$link));
    }

    public function makeTweet($connection, $content)
    {
        $connection->post('statuses/update', array('status' => $content));
    }

    public function postComment($connection, $content, $screen_name, $status_id)
    {
        $connection->post('statuses/update', array('status' => "@".$screen_name." ".$content, 
            'in_reply_to_status_id' => status_id, 'auto_populate_reply_metadata' => true));
        //check 'auto_populate_reply_metadata'
    }

    public function searchPostWithHashtag($connection, $value)
    {
        return $connection->get('search/tweets', array('q' => $value, 'result_type'=>'recent','count'=>'5'));
    }
}
