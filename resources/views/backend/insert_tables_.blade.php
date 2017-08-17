<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/insert_tables.css">
        <script src="/js/jquery.min.js"></script>

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
                        {{-- <Br> --}}
                    @endforeach
                  </label>
                <Br>
              @endforeach
              {{-- <br> --}}
              @foreach ($colors as $color)
                {{-- <input type="file" name="file[{{ $color->id }}]" value=""> --}}
                <label id="picture{{ $color->id }}" class="picture_color" >
                  <br><br>
                  <label class="btn btn-primary pictures_cur" title="Выберите картинку">
                    
                      {{-- <input type="file" id="file-input" style="display: none" name="pict{{ $color->id }}" >
                       {{ $color->title }}
                      <input type="hidden" name="colorid[]" value="{{ $color->id }}"> --}}
                      Выберите картинку {{ $color->title }}
                  </label>
                    @foreach ($pictures as $picture)
                      <label class="picture_label">
                        <input type="radio" name="pict_radio[{{ $color->id }}]" id="radioAll" class="picture_add" value="{{ $picture->id }}">
                        <img src='{{ asset('storage/' . $picture->path . '50_50.jpg') }}' class=img-thumbnail" alt="Responsive image">
                      </label>
                    @endforeach
                </label>
                {{-- <hr class="picture_color" id="picture{{ $color->id }}" /> --}}
                {{-- <ul id="list-view{{ $color->id }}" class="list-view"></ul> --}}
               {{--  <br><br> --}}
              @endforeach
            </p>
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

        //показ/скрытие списка цветов
        var sizeAll = document.querySelectorAll('#cur_size');
        sizeAll.forEach(function(curSize){
          listen(curSize, 'change', function(event) {
            var curSizeId = curSize.value;
            var curColors = $("#color" + curSizeId);//var curColors = document.querySelector("#color" + curSizeId);
            var colorSizeId = 'color' + curSizeId;
            //alert(JSON.stringify(curColorsSize));
            if($(curSize).prop("checked")){//if(curSize.checked){
              $(curColors).css("display", "inline");//curColors.style.display="inline";
            } else{
              $(curColors).css("display", "none");//curColors.style.display="none";
              // alert(JSON.stringify( curColors.childNodes));
              $.each($(curColors).children(), function( index, curColor ) {
                if($(curColor).prop("checked")){//if(curColor.checked){
                  $(curColor).removeAttr("checked");//curColor.checked = false;
                  curColor.dispatchEvent(event_change); 
                  //$(curColor).trigger( "change" );
                }
                
              });
              // curColors.childNodes.forEach(function(curColor){
              //   if(curColor.checked){
              //     curColor.checked = false;
              //     curColor.dispatchEvent(event_change); 
              //     $(curColor).trigger( "change" );
              //   }
                
              // });
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
                  allArrayPicts = $.makeArray(allCurPicts); //преобр объект в массив
                  $.each(allArrayPicts, function( index, curPicture ) {
                    $(curPicture).removeAttr("checked");//curPicture.checked = false;
                    curPicture.dispatchEvent(event_change);
                    //$(curPicture).trigger( "change" );
                  });
                  // allArrayPicts.forEach(function(curPicture){
                  //   curPicture.checked = false;
                  //   curPicture.dispatchEvent(event_change);
                  //   //$(curPicture).trigger( "change" );
                  // });
                  var labelPicts = $(allArrayPicts[0]).parent(".picture_label").siblings(".pictures_cur");
                  $(labelPicts).text("Выберите картинку");
                }
            }
          });
        });

        //изменение надписи кнопок для картинок
        var picturesAdd = document.querySelectorAll('.picture_add');
        picturesAdd.forEach(function(pictureAdd){
          listen(pictureAdd, 'change', function(event) {
            var labelPicts = $(pictureAdd).parent(".picture_label").siblings(".pictures_cur");
            //var labelPicts = $.makeArray(labelPicts);
            if($(pictureAdd).prop("checked")){//if(pictureAdd.checked){
              //alert("title:" + $(labelPicts).attr("title"));
              $(labelPicts).text("Картинка выбрана");
              //alert("Картинка выбрана");
            } else{
              $(labelPicts).text("Выберите картинку");
              //labelPicts.innerHTML = "Выберите картинку";
              //alert("Выберите картинку");
            }
          });
        });



      });
    </script>
</html>
