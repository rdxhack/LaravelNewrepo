@extends('layouts.app')
@section('css')
<style>
    .custom-bg-gray {
        background-color: #f0f0f0; /* Light gray color */
    }
    
</style>
@endsection

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
       <a href="{{ route('home') }}"><button type="button" class="btn btn-success">Home</button></a>
    </div>
    @php
        $images=$post->images;
    @endphp
    <div class="container my-4">
        <div class="row">
            @foreach($images as $image)
                <div class="col-4">
                <button onclick="deleteimage({{$image->id}})"  class="btn" title="Delete Image"><i class="fas fa-trash-alt"></i> </button>
                <img src="http://127.0.0.1:8000/images/{{ $image->image }}" class="card-img-top" style="max-width: 100%; max-height: 100%;" height="150px" width="150px" alt="{{$post->title}}">
                </div>
            @endforeach
        </div>
    </div>
    <form id="myFormedit"  enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="{{$post->id}}" name="postid">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="titleedit" name="title" placeholder="Enter title" value="{{$post->title}}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input class="form-control" id="descriptionedit" name="description" rows="3" placeholder="Enter description" value="{{$post->descripton}}" required></input>
        </div>
        <div class="mb-3">
            <label for="images" class="form-label">Images*</label>
            <input type="file" class="form-control" id="imagesedit" name="images[]" multiple accept="image/*" onchange="previewImages(this.files)" required>
        </div>
        <div id="image-preview" class="d-flex flex-wrap"></div>
        <button type="button" id="submitBtnedit" class="btn btn-primary">Update Post</button>
    </form>

</div>
@endsection

@section('java')

<script>
    function deleteimage(postId) {
        console.log(postId);
    if (confirm("Are you sure you want to delete this Image?")) {
        $.ajax({
            url: "{{ route('delete.image') }}",
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

        $("#submitBtnedit").click(function() {
                $(".error-message").remove();
            var title = $("#titleedit").val();
            var description = $("#descriptionedit").val();
            
            
            if (title.trim() === "") {
                $("#titleedit").after('<span class="error-message" style="color:red">Title is required.</span>');
                return;
            }
            
            if (description.trim() === "") {
                $("#descriptionedit").after('<span class="error-message" style="color:red">Description is required.</span>');
                return;
            }
             
                console.log("Button clicked!");
                var form = document.getElementById("myFormedit");
                var formData = new FormData(form);
                $.ajax({
                    url: "{{ route('update.post') }}", 
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response);
                        window.location.reload();

                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

    function previewImages(files) {
        var preview = document.getElementById("image-preview");
        preview.innerHTML = ""; 
        
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var reader = new FileReader();
            
            reader.onload = function(event) {
                var img = document.createElement("img");
                img.setAttribute("src", event.target.result);
                img.setAttribute("class", "img-thumbnail m-2");
                img.setAttribute("style", "max-width: 150px; max-height: 150px;");
                preview.appendChild(img);
            };
            
            reader.readAsDataURL(file);
        }
    }

</script>

@endsection