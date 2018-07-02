@extends('master')
@section('content')
  <div class="row">
      <div class="col cot1">Bounty Username</div>
      <div class="col cot2">Number Retweet</div>
      <div class="col cot3">Number Tweet</div>
      <div class="col cot4">Tweet Content</div>
      <div class="col cot5">Retweet with quote</div>
      <div class="col cot6">Keyword</div>
      <div class="col cot7">Comment</div>
  </div>
<form action="{{route('bounty-list.store')}}" method="post">
  @csrf
  <div class="form-row">
    <div class="col cot1">
      <input type="text" name="username" class="form-control" placeholder="@name" id="userName">
    </div>
    <div class="col cot2">
      <select class="custom-select" id="numberRetweet" name="numberRetweet" >
        <option selected value= 1>1</option>
        <option value= 2>2</option>
        <option value= 3>3</option>
      </select>
    </div>
    <div class="col cot3">
      <select class="custom-select" id="numberTweet" name="numberTweet">
        <option selected value= 0>0</option>
        <option value= 1>1</option>
        <option value= 2>2</option>
        <option value= 3>3</option>
      </select>

    </div>
    <div class="col cot4">
     <input type="text" class="form-control" placeholder="#hashtag" disabled="" id="tweetContent" name="tweetContent">

    </div>
    <div class="col cot5">
      <select class="custom-select" id="retweetWithQuote" name="retweetWithQuote">
        <option selected value= "No">No</option>
        <option value= "Yes">Yes</option>
        
      </select>
    </div>
    <div class="col cot6">
      <input type="text" class="form-control" placeholder="#hashtag" disabled id="retweetWithQuoteContent" name="retweetWithQuoteContent">
    </div>
    <div class="col cot7">
      <select class="custom-select" id="comment" name="comment">
        <option selected value= 0>No</option>
        <option value= 1>Yes</option>
      </select>
    </div>
  </div>
  <br>
    <div><button type="submit" class="btn btn-danger">Add or Update</button></div>
</form>
    
<table id="sourcetable" style="width: 100%" class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Bounty Username</th>
            <th>Number Retweet</th>
            <th>Number Tweet</th>
            <th>Tweet Content</th>
            <th>Retweet with quote</th>
            <th>Keyword</th>
            <th>Comment</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>1</td>
            <td>Name 1</td>
            <td>1</td>
            <td>0</td>
            <td>Item 1</td>
            <td>Yes</td>
            <td>Item 1</td>
            <td>Item 1</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Name 2</td>
            <td>2</td>
            <td>1</td>
            <td>Item 2</td>
            <td>No</td>
            <td>Item 2</td>
            <td>Item 2</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Name 3</td>
            <td>url 3</td>
            <td>2</td>
            <td>Item 3</td>
            <td>Item 3</td>
            <td>Item 3</td>
            <td>Item 3</td>
        </tr>
        <tr>
            <td>4</td>
            <td>Name 4</td>
            <td>url 4</td>
            <td>3</td>
            <td>Item 4</td>
            <td>Item 4</td>
            <td>Item 4</td>
            <td>Item 4</td>
        </tr>
        <tr>
            <td>5</td>
            <td>Name 5</td>
            <td>url 5</td>
            <td>4</td>
            <td>Item 5</td>
            <td>Item 5</td>
            <td>Item 5</td>
            <td>Item 5</td>
        </tr>
    </tbody>
</table>




{{--   <table  class='table table-striped'>
      <tr>
        <th>Tw ID</th>
        <th>Username</th>
        <th>Remove</th>
      </tr>
      @foreach($twitterAccounts as $twitterAccount)
      <tr>
        <td>{{$twitterAccount->twitter_uid}}</td>
        <td><a href="https://twitter.com/{{$twitterAccount->twitter_username}}">
          <img src="{{$twitterAccount->profile_image_url}}"> {{$twitterAccount->twitter_username}}
          </a>
        </td>
        <td><form onsubmit="return confirm('Are you sure you want to delete this account?')" class="d-inline-block" method="post" action="{{route('twitter-account.destroy', $twitterAccount->id)}}">
          @csrf
          @method('delete')
          <button type="submit" class="btn btn-danger">Delete</button>
        </form></td>
      </tr>
      @endforeach
    </table> --}}
  

@endsection
@section('script')
<script type="text/javascript">

    var pickedup;
    
    var numberTweet = $("#numberTweet");
    var tweetContent = $("#tweetContent");
    var retweetWithQuote = $("#retweetWithQuote");
    var retweetWithQuoteContent = $("#retweetWithQuoteContent");
    var userName = $("#userName");
    var numberRetweet = $("#numberRetweet");
    var comment = $("#comment");
    $(document).ready(function() {
        $( "#sourcetable tbody tr" ).on( "click", function( event ) {

              // get back to where it was before if it was selected :
              if (pickedup != null) {
                  pickedup.css( "background-color", "#fff" );
              }

              userName.val($(this).find("td").eq(1).html());
              numberRetweet.val($(this).find("td").eq(2).html());
              numberTweet.val($(this).find("td").eq(3).html());
              tweetContent.val($(this).find("td").eq(4).html());
              retweetWithQuote.val($(this).find("td").eq(5).html());
              retweetWithQuoteContent.val($(this).find("td").eq(6).html());
              comment.val($(this).find("td").eq(7).html());

              if (numberTweet.val() != 0) {
                tweetContent.prop('disabled', false);
              }
              else {
                tweetContent.prop('disabled', true);
              }
              

             
              if (retweetWithQuote.val() == "Yes") {
                retweetWithQuoteContent.prop('disabled', false);
              }
              else {
                retweetWithQuoteContent.prop('disabled', true);
              }
              $( this ).css( "background-color", "green" );

              pickedup = $( this );
        });

        numberTweet.change(function() {
            tweetContent.prop('disabled', true);
            if ($(this).val() != 0) {
              tweetContent.prop('disabled', false);
            }
          });
        retweetWithQuote.change(function() {
            retweetWithQuoteContent.prop('disabled', true);
            if ($(this).val() == "Yes") {
              retweetWithQuoteContent.prop('disabled', false);
            }
          });
    });


  </script>

@endsection