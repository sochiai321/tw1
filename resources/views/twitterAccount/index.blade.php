@extends('master')
@section('content')
  <h1>All posts</h1>
  
  <a href="{{$url}}" class="btn btn-primary">Sign In with Twitter</a>



  <table  class='table table-striped'>
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
    </table>
  

@endsection
