@extends('layouts.app')

@section('mycss')
  {{-- <link rel="stylesheet" href="/css/bootstrap.min.css"> --}}
  {{-- <link rel="stylesheet" href="/css/welcome.css"> --}}
@endsection

@section('content')
        <form method="POST" action="/store_pict" ENCTYPE="multipart/form-data">
          {{ csrf_field() }}
          <label class="btn btn-primary" title="Кликни для замены">
            <input style="display: none" name="pict" type="file" onchange="submit()">
            Добавить картинку
          </label>
@endsection
    {{-- <form action="">
            <input type="file" id="file-input" multiple="multiple" accept="image/jpeg" />
        </form>
        <hr/>
        <ul id="list-view"></ul> --}}

@section('myjs')
    <script>
        var listen = function(element, event, fn) {
            return element.addEventListener(event, fn, false);
        };

        listen(document, 'DOMContentLoaded', function() {

            var fileInput = document.querySelector('#file-input');
            var listView = document.querySelector('#list-view');

            listen(fileInput, 'change', function(event) {
                var files = fileInput.files;
                if (files.lenght == 0) {
                    return;
                }
                for(var i = 0; i < files.length; i++) {
                    generatePreview(files[i]);
                }
                fileInput.value = "";
            });

            var generatePreview = function(file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var dataUrl = e.target.result;
                    var li = document.createElement('LI');
                    var image = new Image();
                    image.width = 100;
                    image.onload = function() {
                        // some action here
                    };
                    image.src = dataUrl;
                    li.appendChild(image);
                    listView.appendChild(li);
                };
                reader.readAsDataURL(file);
            };
        });
    </script>
@endsection

