@extends('layouts.backend')

@section('mycss')
  {{-- <link rel="stylesheet" href="/css/bootstrap.min.css"> --}}
  {{-- <link rel="stylesheet" href="/css/welcome.css"> --}}
  {{-- <script src="/js/jquery.min.js"></script>
  <script src="/js/bootstrap.min.js"></script> --}}
  <link rel="stylesheet" href="/css/edit_tables.css">
@endsection

@section('content')

        <form method="POST" action="/store_edit_tables">
            {{ csrf_field() }}
            <input type="text" class="form-control" name="en" value="{{ $good->en }}" placeholder="Название">
            <input type="text" class="form-control" name="ru" value="{{ $good->ru }}" placeholder="Title">
            <br>
            <select type="text" class="form-control" name="descriptions" value="" required
            >
              @foreach ($descrs as $descr)
                <?php $selected = '' ?>
                @if ($good->descriptions_id == $descr->id)
                  <?php $selected = 'selected' ?>
                @endif
                <option value="{{ $descr->id }}" {{ $selected }}>{{ $descr->$language }}</option>
              @endforeach
            </select>
            <br>
            <select type="text" class="form-control" name="category" value="" required
            >
              @foreach ($categories as $category)
                <?php $selected = '' ?>
                @if ($good->categories_id == $category->id)
                  <?php $selected = 'selected' ?>
                @endif
                <option value="{{ $category->id }}" {{ $selected }}>{{ $category->$language }}</option>
              @endforeach
            </select>
            <br>
            <select type="text" class="form-control" name="subcat" value="" required
            >
              @foreach ($subcats as $subcat)
                <?php $selected = '' ?>
                @if ($good->subcategories_id == $subcat->id)
                  <?php $selected = 'selected' ?>
                @endif
                <option value="{{ $subcat->id }}" {{ $selected }}>{{ $subcat->$language }}</option>
              @endforeach
            </select>
            <br>
            <p>
              @foreach ($sizes as $size)
                <?php $checked= ''; $display = 'none'; ?>
                <?php 
                  if (in_array($size->id, $curszs)){
                    $checked = 'checked';
                    $display = 'inline';
                  }
                ?>
                <input type="checkbox" name="size[]" id="cur_size" value="{{ $size->id }}" {{ $checked }}>{{ $size->$language }}
                  <label id="color{{ $size->id }}" class="color_size" style="display:{{ $display }};"> 
                    @foreach ($colors as $color)
                      <?php $checked = '' ?>
                      @if (isset($curclrs[$size->id]))
                        @if (in_array($color->id, $curclrs[$size->id]))
                          <?php $checked = 'checked' ?>
                          <?php $curclrs2[] = $color->id; ?>
                        @endif
                      @endif
                      <input type="checkbox" name="color[{{ $size->id }}][]" data-name-size="color{{ $size->id }}" id="cur_color" value="{{ $color->id }}" {{ $checked }}>{{ $color->$language }} 
                    @endforeach
                  </label>
                <br>
              @endforeach
            </p>
              @foreach ($colors as $color)
                <?php $display = 'none' ?>
                @if (isset($curclrs2))
                  @if (in_array($color->id, $curclrs2))
                    <?php $display = 'inline' ?>
                  @endif
                @endif
                <label id="picture{{ $color->id }}" class="picture_color"  style="display:{{ $display }};">
                  <br><br>
                  <label class="btn btn-primary pictures_cur" data-toggle="modal" data-target="#myModal{{ $color->id }}" title="Выберите картинку">
                    <label>
                      Выберите картинку
                    </label>
                      {{ $color->$language }}
                  </label>
                  <ul id="list-view{{ $color->id }}" class="list-view">
                    @if(isset($pictPath[$color->id]))
                      <li>
                        <img src='{{ asset('storage/' . $pictPath[$color->id] . '50_50.jpg') }}' class="img-thumbnail" alt="Responsive image">
                      </li>
                    @endif
                  </ul>
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
                            <?php $backgr_color = '#fff';  $checked = '';?>
                            @if (isset($pictId[$color->id]))
                              @if ($pictId[$color->id] == $picture->id)
                                <?php $backgr_color = '#e805f6'; $checked = 'checked'; ?>
                              @endif
                            @endif
                            <label class="picture_label">
                              <input type="radio" name="pict_radio[{{ $color->id }}]" id="radioAll" class="picture_add" value="{{ $picture->id }}" data-input-colorid="{{ $color->id }}" {{ $checked }}>
                                <img src='{{ asset('storage/' . $picture->path . '50_50.jpg') }}' class="img-thumbnail" alt="Responsive image" style="background-color:{{$backgr_color}};">
                              
                            </label>
                          @endforeach
                        </div>
                        <div class="modal-footer myModal-image">
                          <button type="button" class="btn btn-default" data-dismiss="modal" data-close-colorid="{{ $color->id }}">Close</button>
                          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                        </div>
                      </div>
                    </div>
                  </div>
                </label>
              @endforeach
            
            <input type="hidden" name="id" value="{{ $good->id }}">
            <button type="send" class="btn btn-success">Готово</button>
        </form>
        <br><br>
@endsection

@section('myjs')
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
                image.classList.add("img-thumbnail");
                image.style.backgroundColor = '#e805f6';
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
@endsection
