@extends('master')
@section('content')
  <h1>All posts</h1>
  <a href="{{route('posts.create')}}" class="btn btn-primary">Create Post</a>
  <div style="height: 50px;"></div>
  <table  class='table table-striped'>
    <tr>
      <th>Title</th>
      <th>Edit</th>
      <th>Remove</th>
    </tr>
    @foreach($posts as $post)
    <tr>
      <td><a href="{{route('posts.show', $post->id)}}">
          {{$post->title}}
        </a></td>
      <td> <a href="{{route('posts.edit', $post->id)}}" class="btn btn-info">Edit</a></td>
      <td><form onsubmit="return confirm('Are you sure you want to delete this post?')" class="d-inline-block" method="post" action="{{route('posts.destroy', $post->id)}}">
          @csrf
          @method('delete')
          <button type="submit" class="btn btn-danger">Delete</button>
        </form></td>
    </tr>
    @endforeach
  </table>
  
  {{-- <div class="card mt-4">
    <div class="card-body">
      <h2>
        
       
        
      </h2>

    </div>
  </div> --}}
  
  <div class="mt-4">
    {{$posts->links()}}
  </div>
@endsection
