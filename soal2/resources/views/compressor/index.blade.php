@extends('layouts.app')
@section('title', 'Hackaton - Image Compressor')

@section('content')
    <main>
        <div class="container">
            <h1>Image Compressor</h1>
            <div class="file-drop-area">
                <span class="fake-btn">Choose files</span>
                <span class="file-msg">or drop files here</span>
                <input class="file-input" type="file" multiple accept="image/jpeg, image/webp">
            </div>
            <div class="file-preview-container d-flex">
                <img src="" alt="Preview" class="file-preview">
                <img src="" alt="Preview" class="file-preview-compressed">
            </div>
            <button class="btn btn-primary" id="compress-btn">Compress</button>
            <div class="progress-container">
                <div class="progress-bar" style="width: 0"></div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('.file-input').on('change', function() {
                const file = $(this)[0].files[0];
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('.file-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            });

            $('#compress-btn').on('click', function() {
                const file = $('.file-input')[0].files[0];
                const formData = new FormData();
                formData.append('image', file);

                $.ajax({
                    xhr: function() {
                        const xhr = new XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function(e) {
                            if (e.lengthComputable) {
                                const progress = Math.round((e.loaded / e.total) * 100);
                                $('.progress-bar').css('width', progress + '%');
                            }
                        });
                        return xhr;
                    },
                    url: '/api/compress',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        alert('Image compressed successfully');
                        $('.progress-bar').css('width', '0');
                        $('.file-preview-compressed').attr('src', response.data.new_path); 
                    },
                    error: function(error) {
                        console.log(error);
                        alert('Error while compressing image');
                        $('.progress-bar').css('width', '0');
                    }
                });
            });
        });
    </script>
@endsection

@push('styles')
<style>
.container{
height: 100%;
padding: 0;
margin: 0;
display: flex;
flex-direction: column;
align-items: center;
justify-content: center;
}

.file-drop-area {
position: relative;
display: flex;
flex-direction: column;
align-items: center;
width: 90%;
height: 400px;
padding: 25px;
background-color: #fff;
border-radius: 12px;
box-shadow: 10px 10px 20px 10px rgba(0,0,0,.1);
transition: .3s;
}
.file-drop-area.is-active {
background-color: #1a1a1a;
}

.fake-btn {
flex-shrink: 0;
background-color: #9699b3;
border-radius: 3px;
padding: 8px 15px;
margin-right: 10px;
font-size: 12px;
text-transform: uppercase;
}

.file-msg {
color: #9699b3;
font-size: 16px;
font-weight: 300;
line-height: 1.4;
white-space: nowrap;
overflow: hidden;
text-overflow: ellipsis;
}

.file-input {
position: absolute;
left: 0;
top: 0;
height: 100%;
width: 100%;
cursor: pointer;
opacity: 0;
}
.file-input:focus {
outline: none;
}

.file-preview {
display: flex;
flex-wrap: wrap;
justify-content: center;
width: 50%;
margin-top: 20px;
}
.file-preview-compressed {
display: flex;
flex-wrap: wrap;
justify-content: center;
width: 50%;
margin-top: 20px;
}
.file-preview img {
width: 100px;
height: 100px;
margin: 10px;
object-fit: cover;
}
.file-preview-compressed img {
width: 100px;
height: 100px;
margin: 10px;
object-fit: cover;
}
</style>
@endpush


