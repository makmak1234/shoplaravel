<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/some-minimal-styles.css">

        <title>Laravel</title>

    </head>
    <body>
        <form method="POST" action="/store_tables">
            {{ csrf_field() }}
            <input type="text" class="form-control" name="title" value="" placeholder="Название">
            <br>
            <select type="text" class="form-control" name="descriptions" value="" required
            >
              @foreach ($descrs as $descr)
                <option value="{{ $descr->id }}">{{ $descr->title }}</option>
              @endforeach
            </select>
            <br>
            <p>
              @foreach ($sizes as $size)
                <input type="checkbox" name="size[]" value="{{ $size->id }}">{{ $size->title }}
                    @foreach ($colors as $color)
                      <input type="checkbox" name="color[{{ $size->id }}][]" value="{{ $color->id }}">{{ $color->title }} 
                      {{-- <Br> --}}
                    @endforeach
                <Br>
              @endforeach
              <br>
                @foreach ($colors as $color)
                  {{-- <input type="file" name="file[{{ $color->id }}]" value=""> --}}
                  <label class="btn btn-primary" title="Кликни чтобы добавить">
                    
                    {{ csrf_field() }}
                      <input type="file" id="file-input" style="display: none" name="pict{{ $color->id }}" >
                      Добавить картинку {{ $color->title }}
                      <input type="hidden" name="colorid[]" value="{{ $color->id }}">
                    
                  </label>
                  @foreach ($pictures as $picture)
                    <label>
                      <input type="radio" name="pict_radio[{{ $color->id }}]" id="radioAll" value="{{ $picture->id }}">
                      <img src='{{ asset('storage/' . $picture->path . '50_50.jpg') }}' class=img-thumbnail" alt="Responsive image">
                    </label>
                  @endforeach
                  </select>
                  <hr/>
                  <ul id="list-view{{ $color->id }}" class="list-view"></ul>
                  <br><br>
                @endforeach
            </p>
            <button type="send" class="btn btn-success">Готово</button>
        </form>
    </body>


    <script>
      var listen = function(element, event, fn) {
          return element.addEventListener(event, fn, false);
      };

      listen(document, 'DOMContentLoaded', function() {

          var fileInput = document.querySelectorAll('#file-input'); //querySelectorAll

alert(document.querySelector('#radioAll').Attr(cur_pict));

var radioPict = document.querySelectorAll('#radioAll');
radioPict.forEach(function(curRadioPict){
  listen(radioPict, 'change', function(event){
    var curIdPict = curRadioPict.element(cur_pict);
    alert(curIdPict.name);
  });
});

          fileInput.forEach(function(curfileInput){
            listen(curfileInput, 'change', function(event) {
              var curlistView = curfileInput.name;
              var curlistView = curlistView.replace("pict", "");
              var curlistView = '#list-view' + curlistView;
              var files = curfileInput.files;
              if (files.lenght == 0) {
                  return;
              }
              for(var i = 0; i < files.length; i++) {
                  generatePreview(files[i], curlistView);
              }
              curfileInput.value = "";
            });
          });

          

          var generatePreview = function(file, curlistView) {
              var listView = document.querySelector(curlistView); //'#list-view'+...
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
                  //alert(image);
                  li.appendChild(image);
                  //alert(li);
                  var oldli = document.querySelector(curlistView + ' > li');
                  if(oldli != null) oldli.remove();
                  listView.appendChild(li);
              };
              reader.readAsDataURL(file);
          };
      });
    </script>
</html>
