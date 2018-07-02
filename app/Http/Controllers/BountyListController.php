<?php

namespace App\Http\Controllers;
use App\Consts;
use Illuminate\Http\Request;
use DB;
use Log;
use \Exception;
use App\TwitterAccount;
use App\User;
use App\BountyList;
use App\MasterBountyList;
use App\Http\Services\TwitterService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Abraham\TwitterOAuth\TwitterOAuth;

class BountyListController extends Controller
{
    
    private $twitterService;
    public function __construct () {
        $this->middleware('auth');
        $this->twitterService = new TwitterService();
    }

    public function getCurrentTwitterAcccount() {
        return TwitterAccount::where('isActive', 1)->where('userID', Auth::id())->first();

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function index()
    {
        
        if($twitterAccount = $this->getCurrentTwitterAcccount()) { 
            $bountyLists = BountyList::orderBy('id', 'desc')
                            ->where('twitter_account_uid', $twitterAccount->id)
                            ->get();
            return view('bountyList.index',['bountyLists' => $bountyLists]);
           
        } else{
            return view('bountyList.index');
        }
        


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $twuseruid = $this->twitterService->getBountyUid($request->username);

        DB::beginTransaction();
        try {
            $masterBountyList = MasterBountyList::firstOrNew([
                'bounty_uid' => $twuseruid
            ]);
            $masterBountyList->bounty_username = $request->username;
            $masterBountyList->save();

            $BountyList = BountyList::updateOrCreate(
                ['twitter_account_uid' => $twuseruid],
                ['bounty_username' => $request->username,
                 'bounty_uid' => $masterBountyList->id,
                 'number_of_retweet' => $request->numberRetweet,
                 'number_of_tweet' => $request->numberTweet,
                 'tweet_keyword' => $request->tweetContent,
                 'number_of_tweet_with_quote' => convertStringToNumber($request->retweetWithQuote),
                 'tweet_with_quote_keyword' => $request->retweetWithQuoteContent,
                 'comment_enabled' => convertStringToNumber($request->comment_enabled),

             ]
            );
            
            DB::commit();

        } catch (\Exception $e) {
            Log::error("Error creating new user: " . $e->getMessage());
            DB::rollback();
            throw $e;
        }
        return view('bountyList.index');
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
    
    
}
