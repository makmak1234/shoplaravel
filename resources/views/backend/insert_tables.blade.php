<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/insert_tables.css">
        <script src="/js/jquery.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>

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
                <input type="checkbox" name="size[]" id="cur_size" value="{{ $size->id }}">{{ $size->title }}
                  <label id="color{{ $size->id }}" class="color_size"> 
                    @foreach ($colors as $color)
                        <input type="checkbox" name="color[{{ $size->id }}][]" data-name-size="color{{ $size->id }}" id="cur_color" value="{{ $color->id }}" >{{ $color->title }} 
                    @endforeach
                  </label>
                <Br>
              @endforeach
            </p>
              @foreach ($colors as $color)
                <label id="picture{{ $color->id }}"" class="picture_color" >
                  <br><br>
                  <label class="btn btn-primary pictures_cur" data-toggle="modal" data-target="#myModal{{ $color->id }}" title="Выберите картинку">
                    <label>
                      Выберите картинку
                    </label>
                      {{ $color->title }}
                  </label>
                  <ul id="list-view{{ $color->id }}" class="list-view"></ul>
                  {{-- @foreach ($pictures as $picture)
                    <label class="picture_label">
                      <input type="radio" name="pict_radio[{{ $color->id }}]" id="radioAll" class="picture_add" value="{{ $picture->id }}">
                      <img src='{{ asset('storage/' . $picture->path . '50_50.jpg') }}' class=img-thumbnail" alt="Responsive image">
                    </label>
                  @endforeach --}}
                  <!-- Modal -->
                  <div class="modal fade" id="myModal{{ $color->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                        </div>
                        <div class="modal-body">
                          @foreach ($pictures as $picture)
                            <label class="picture_label">
                              <input type="radio" name="pict_radio[{{ $color->id }}]" id="radioAll" class="picture_add" value="{{ $picture->id }}" data-input-colorid="{{ $color->id }}">
                                <img src='{{ asset('storage/' . $picture->path . '50_50.jpg') }}' class="img-thumbnail" alt="Responsive image">
                              
                            </label>
                          @endforeach
                        </div>
                        <div class="modal-footer myModal-image">
                          <button type="button" class="btn btn-default" data-dismiss="modal" data-close-colorid="{{ $color->id }}">Close</button>
                          <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </label>
              @endforeach
            
            <button type="send" class="btn btn-success">Готово</button>
        </form>
    </body>


    <script>
      var listen = function(element, event, fn) {
          return element.addEventListener(event, fn, false);
      };

      listen(document, 'DOMContentLoaded', function(){

        //alert(picturesAdd.length);
        var event_change = new Event("change");
        var event_click = new Event("click");

        //показ/скрытие списка цветов
        var sizeAll = document.querySelectorAll('#cur_size');
        sizeAll.forEach(function(curSize){
          listen(curSize, 'change', function(event) {
            var curSizeId = curSize.value;
            var curColors = document.querySelector("#color" + curSizeId);
            var colorSizeId = 'color' + curSizeId;
            //alert(JSON.stringify(curColorsSize));
            if(curSize.checked){
              curColors.style.display="inline";
            } else{
              curColors.style.display="none";
              // alert(JSON.stringify( curColors.childNodes));
              curColors.childNodes.forEach(function(curColor){
                if(curColor.checked){
                  curColor.checked = false;
                  curColor.dispatchEvent(event_change); 
                }
                
              });
            }
          });
        });

        //показ/скрытие списка картинок
        var colorAll = document.querySelectorAll('#cur_color');
        colorAll.forEach(function(curColor){
          listen(curColor, 'change', function(event) {
            var curColorId = curColor.value;
            var curPictures = document.querySelector("#picture" + curColorId);
            if(curColor.checked){
              curPictures.style.display="inline";
            } else{
              var colorAllEqual = $('label.color_size input[value^="'+curColorId+'"]');
              colorAllEqual = $.makeArray(colorAllEqual); //преобр объект в массив
              //alert(colorAllEqual.length);
              var trueChecked = false;
              for (var i = 0; i < colorAllEqual.length; i++) {
                if(colorAllEqual[i].checked && curColor.getAttribute('data-name-size') != colorAllEqual[i].getAttribute('data-name-size')){
                  var trueChecked = true;
                  //alert('trueChecked1: ' + trueChecked);
                }
              }
              //alert('trueChecked2: ' + trueChecked);
              if(!trueChecked){
                curPictures.style.display="none";
                var allCurPicts = curPictures.getElementsByTagName("input");
                // alert(JSON.stringify($.makeArray(allCurPicts)));
                var allArrayPicts = $.makeArray(allCurPicts); //преобр объект в массив
                allArrayPicts.forEach(function(curPicture){
                  if(curPicture.checked){
                    curPicture.checked = false;
                    $(curPicture).siblings('img').css('background-color', '#fff');
                    var curlistView = $(curPicture).attr("data-input-colorid");//var curlistView = curfileInput.name;
                    //var curlistView = curlistView.replace("pict_radio", "");
                    var curlistView = '#list-view' + curlistView;
                    //alert(curlistView);
                    var listView = document.querySelector(curlistView); //'#list-view'+...
                    var oldli = document.querySelector(curlistView + ' > li');
                    if(oldli != null) oldli.remove();
                    //curPicture.dispatchEvent(event_change); 
                  }
                });
                var labelPicts = $(allArrayPicts[0]).parent(".picture_label").siblings(".pictures_cur");
                var labelPicts = $.makeArray(labelPicts);
                $(labelPicts).children().text("Выберите картинку");//labelPicts.innerHTML = "Выберите картинку";
                $(labelPicts).removeClass("btn-success");
                $(labelPicts).addClass("btn-primary");
              }
            }
          });
        });

        // изменение надписи кнопок для картинок, управление модальным окном
        var picturesAdd = document.querySelectorAll('.picture_add');
        //alert(picturesAdd.length);
        picturesAdd.forEach(function(pictureAdd){
          listen(pictureAdd, 'change', function(event) {
            var labelPicts = $(pictureAdd).parent(".picture_label").siblings(".pictures_cur");
            var labelPicts = $.makeArray(labelPicts);
            if(pictureAdd.checked){
              //alert(JSON.stringify(labelPicts));
              $(labelPicts).children().text("Картинка выбрана");//labelPicts.innerHTML = "Картинка выбрана";
              $(labelPicts).removeClass("btn-primary");
              $(labelPicts).addClass("btn-success");
              //alert("Картинка выбрана");
              var modalImageId = $(pictureAdd).attr("data-input-colorid");
              var modalImage = $('.myModal-image button[data-close-colorid^="'+modalImageId+'"]');
              var modalImage = $.makeArray(modalImage);
              var picture = $(pictureAdd).siblings('.img-thumbnail');
              $(picture).css('background-color', '#e805f6');
              var picture_label = $(pictureAdd).parent('.picture_label');
              var picture_labeles = $(picture_label).siblings('.picture_label');
              var picture_labeles = $.makeArray(picture_labeles);
              picture_labeles.forEach(function(picture_lab){
                $(picture_lab).children('img').css('background-color', '#fff');
              });
              //alert(JSON.stringify($(modalImage).children(".btn-default")));
              $(modalImage).click();
            } else{
              var picture = $(pictureAdd).siblings('.img-thumbnail');
              $(picture).css('background-color', '#fff');
            }
          });
        });

        //предпросмотр картинок
        var fileInput = document.querySelectorAll('#radioAll'); //querySelectorAll

        fileInput.forEach(function(curfileInput){
          listen(curfileInput, 'change', function(event) {
            var curlistView = $(curfileInput).attr("data-input-colorid");//var curlistView = curfileInput.name;
            //var curlistView = curlistView.replace("pict_radio", "");
            var curlistView = '#list-view' + curlistView;
            files = $(curfileInput).siblings('img');//var files = curfileInput.files;
            //alert(files);
            if (files.lenght == 0) {
                return;
            }
            //for(var i = 0; i < files.length; i++) {
                generatePreview(files, curlistView);
            //}
            //curfileInput.value = "";
          });
        });
        
        var generatePreview = function(file, curlistView) {
            var listView = document.querySelector(curlistView); //'#list-view'+...
            // var reader = new FileReader();
            // reader.onload = function(e) {
                var dataUrl = $(file).attr('src');//e.target.result;
                //alert(dataUrl);
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
            // };
            // reader.readAsDataURL(file);
        };

        //управление модальным окном
        //var modalsImage = document.querySelectorAll('myModal-image');
        // $.each(picturesAdd, function( index, pictureAdd ) {
        //   listen(pictureAdd, 'change', function(event) {
        //     alert("press on image");
        //     var modalImage = $(pictureAdd).parent(".modal-body").siblings(".myModal-image");
        //     $(modalImage).children(".btn-default").click();
        //   });
        // });

      });
    </script>
</html>
