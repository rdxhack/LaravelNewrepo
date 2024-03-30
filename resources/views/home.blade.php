@extends('layouts.app')
@section('css')
<style>
    .custom-bg-gray {
        background-color: #f0f0f0; /* Light gray color */
    }
</style>
@endsection
@section('content')
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="container">

</div>
<div class="container ">
        <div id="status">
        </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
       <a href="{{ route('add.post') }}"><button type="button" class="btn btn-success">Add Post</button></a>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                Filter
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" onclick="filterPost(7)" >7 day before </a></li>
                <li><a class="dropdown-item" onclick="filterPost(30)">30 day before </a></li>
                <li><a class="dropdown-item" onclick="filterPost(1000)">ALL Post</a></li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-0"></div>
        <div class="col-12">
            <div class="container">
                <div class="row">
                    
                    @foreach($post as $post)
                    <div class="col-4 mt-3">
                        <div class="card">
                            <img src="http://127.0.0.1:8000/images/{{ $post->images[0]->image }}" class="card-img-top" style="max-width: 100%; max-height: 100%;" height="150px" width="150px" alt="{{$post->title}}">
                            <div class="card-body">
                                <h5 class="card-title" style="color:#5e0de1">{{$post->title}}</h5>
                                <p class="card-text" style="font-size: small;">{{$post->descripton}}</p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('edit.post',$post->id) }}" type="button" class="btn" title="Edit"><i class="fas fa-edit"></i> </a>
                                <button onclick="deletePost({{ $post->id }})"  class="btn" title="Delete"><i class="fas fa-trash-alt"></i> </button>
                            </div>
                        </div>
                    </div>
                    @endforeach  
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('java')
<script>
    function deletePost(postId) {
    if (confirm("Are you sure you want to delete this post?")) {
        $.ajax({
            url: "{{ route('delete.post') }}",
            type: "POST",
            data: {
                id: postId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                window.location.reload();
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
}

 function filterPost(filter){
    $.ajax({
            url: "{{ route('filter.post') }}",
            type: "POST",
            data: {
                filter: filter,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                window.location.reload();
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
 }

</script>
@endsection