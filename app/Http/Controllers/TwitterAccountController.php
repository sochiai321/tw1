<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\TwitterAccount;
use App\User;
use App\Consts;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterAccountController extends Controller
{
    

    public function __construct () {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function index()
    {
        $twitterAccounts = TwitterAccount::orderBy('id', 'desc')
                            ->where('userID', Auth::id())
                            ->where('isDisable', 0)
                            ->get();

        // if(!Session::has('access_token')){

            $connection = new TwitterOAuth(Consts::CONSUMER_KEY,Consts::CONSUMER_SECRET);
            $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => 
                Consts::OAUTH_CALLBACK));
            Session::put('oauth_token', $request_token['oauth_token']);
            Session::put('oauth_token_secret', $request_token['oauth_token_secret']);
            $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
            return view('twitterAccount.index')
                            ->with('url', $url)
                            ->with('twitterAccounts', $twitterAccounts);
           
        // } else{
        //     $access_token = Session::get('access_token');
        //     $connection = new TwitterOAuth(
        //         Consts::CONSUMER_KEY, 
        //         Consts::CONSUMER_SECRET, 
        //         $access_token['oauth_token'], 
        //         $access_token['oauth_token_secret']);
        //     $user = $connection->get("account/verify_credentials");
        //     return $user->screen_name;
        // }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }
    public function callback(Request $request)
    {
        
        if ($request->has('oauth_verifier') && 
            $request->has('oauth_token')  && 
            $request['oauth_token'] == Session::get('oauth_token')) {


            $request_token = [];
            $request_token['oauth_token'] = Session::get('oauth_token');
            $request_token['oauth_token_secret'] = Session::get('oauth_token_secret');

            $connection = new TwitterOAuth(Consts::CONSUMER_KEY, Consts::CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);

            $access_token = $connection->oauth("oauth/access_token", array(
                "oauth_verifier" => $request['oauth_verifier']));

            $connection = new TwitterOAuth(
                Consts::CONSUMER_KEY, 
                Consts::CONSUMER_SECRET, 
                $access_token['oauth_token'], 
                $access_token['oauth_token_secret']);
            $user = $connection->get("account/verify_credentials");
            Session::put('access_token', $access_token);    
            // if(User::find(Auth::id())->twitterAccount()->where('twitter_uid', $user->id_str)->first()){
            //     TwitterAccount::where('twitter_uid', $user->id_str)
            //             ->update(['isDisable' => 0]);
            //     return redirect()->route('twitter');
            // }



            $twitterAccount = TwitterAccount::where('twitter_uid',$user->id_str)->first();
            $this->deactiveCurrentTwitterAccount();
            if(!$twitterAccount || $twitterAccount->userID == Auth::id()){
                $tA = TwitterAccount::updateOrCreate(
                    ['twitter_uid' => $user->id_str],
                    ['userID' => Auth::id(),
                    'twitter_username' => $user->screen_name,
                    'isDisable' => 0,
                    'isActive' => 1,
                    'Access_Token' => $request_token['oauth_token'],
                    'Access_Token_Secret' => $request_token['oauth_token_secret'],
                    'profile_image_url' => $user->profile_image_url
                    ]
                );
                
                return redirect()->route('twitter')->with(['result' => true]);
            }
            
                return redirect()->route('twitter')->with(['result' => false]);
                
            


            
            
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('twitterAccount.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        TwitterAccount::where('id', $id)
            ->update(['isDisable' => 1]);
        return redirect(route('twitter-account.index'));
    }
    public function deactiveCurrentTwitterAccount()
    {   
        
            $twitterAccount = TwitterAccount::where('userID', Auth::id())
                                        ->where('isActive', 1)
                                        ->first();
            if ($twitterAccount) 
                {
                    $twitterAccount->isActive =0;
                    $twitterAccount->save();
                }                            
             
            

                                            
    }
}
