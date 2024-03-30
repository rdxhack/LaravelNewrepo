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
        <div id="status">
        </div>
    
    <div class="d-flex justify-content-between align-items-center mb-3">
       <a href="{{ route('home') }}"><button type="button" class="btn btn-success">Home</button></a>
    </div>
    <form id="myForm"  enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description" required></textarea>
        </div>
        <div class="mb-3">
            <label for="images" class="form-label">Images*</label>
            <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*" onchange="previewImages(this.files)" required>
        </div>
        <div id="image-preview" class="d-flex flex-wrap"></div>
        <button type="button" id="submitBtn" class="btn btn-primary">Submit</button>
    </form>

</div>
@endsection

@section('java')
<script>
$(document).ready(function() {
        $("#submitBtn").click(function() {
                $(".error-message").remove();
            var title = $("#title").val();
            var description = $("#description").val();
            
            
            if (title.trim() === "") {
                $("#title").after('<span class="error-message" style="color:red">Title is required.</span>');
                return;
            }
            
            if (description.trim() === "") {
                $("#description").after('<span class="error-message" style="color:red">Description is required.</span>');
                return;
            }
             
                console.log("Button clicked!");
                var form = document.getElementById("myForm");
                var formData = new FormData(form);
                $.ajax({
                    url: "{{ route('store.post') }}", 
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log(response);
                        alert("Your Post Save Successfully Thanks!");
                        document.getElementById('myForm').reset();
                        document.getElementById('image-preview').value = '';
                        window.location.reload();

                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
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