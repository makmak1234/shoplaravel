{{-- @if(isset($showTables) && !empty($showTables))
  @php
    // echo 'showTables';
    // $myecho = json_encode($showTables);
    // `echo " showTables blade    " >>/tmp/qaz`;
    // `echo "$myecho" >>/tmp/qaz`;

    // echo $showTables;
    exit;
  @endphp

@else

@php
  ob_start();
@endphp --}}

@extends('layouts.app')

@section('mycss')
  {{-- <link rel="stylesheet" href="/css/bootstrap.min.css"> --}}
  <link rel="stylesheet" href="/css/welcome.css">
@endsection

@section('content')

  <br>
            <div class="content">
                <div class="container">
                    <div class="btn-group" role="group" aria-label="...">
                      <a href="/insert_tables" type="button" class="btn btn-default">Добавить запись</a>
                      <a href="/show_category" type="button" class="btn btn-default">Редактировать категории</a>
                      <a href="/show_subcat" type="button" class="btn btn-default">Редактировать субкатегории</a>
                      <a href="/show_descr" type="button" class="btn btn-default">Редактировать описание</a>
                      <a href="/show_size" type="button" class="btn btn-default">Редактировать размер</a>
                      <a href="/show_color" type="button" class="btn btn-default">Редактировать цвет</a>
                      <a href="/show_pict" type="button" class="btn btn-default">Редактировать картинки</a>
                      <a href="/clear_cache" type="button" class="btn btn-danger">Стереть кеш</a>
                    </div>
                    <div class="slogan">
                        <h1>Все категории</h1>
                    </div> 
                    <div class="bread-crumbs"></div>
                    @foreach ($categories as $category)
                      @if (Cache::has('showTables'.$category->id)) 
                     {{--  @if (file_exists('./cache/showTables'.$loop->iteration.'.cache')) --}}
                        @php
                          // $showTables = readfile('./cache/showTables'.$loop->iteration.'.cache');
                          $showTables = Cache::get('showTables'.$loop->iteration);

                          $myecho = $showTables;
                          // `echo " showTables $loop->iteration  " >>/tmp/qaz`;
                          `echo "cache: true" >>/tmp/qaz`;
                          //exit;

                          echo $showTables;
                          continue;
                        @endphp
                      @else
                      @php 
                        ob_start();
                      @endphp
                      <div class="thumbnail">
                        <div class="caption text-center"> 
                          <h2>{{ $category->title }}</h2>
                        </div>
                        <img src="{{ asset('storage/' . $category->path . '50_50.jpg') }}" alt="...">
                                       
                      @php $subcats = $category->subcategory; 
                      @endphp
                      @foreach ($subcats as $subcat)
                        @php 
                          $goods = App\Goods::where([
                              ['categories_id', '=', $category->id],
                              ['subcategories_id', '=', $subcat->id],
                          ])->get();
                        @endphp
                        
                        <h3>{{ $subcat->title }} <small>({{ $category->title }})</small></h3>
                        {{-- {{json_encode($goods)}} --}}
                        <div class="row content-main">
                          <?php $myClear = 3; ?>
                          @foreach ($goods as $good)
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <div class="thumbnail">
                                <div class="row">                                    
                                  <?php $allcolor = array(); ?>
                                  <?php $myClearImg = 3; $curLoop = 1;?>
                                  @foreach ($good->size as $s)
                                    <?php $goodsSizes = App\GoodsSizes::where('id', $s->pivot->id)->get(); ?>
                                    @foreach ($goodsSizes as $goodSize)
                                      @foreach ($goodSize->color as $col)
                                        @if (!(in_array($col->id, $allcolor)))
                                          <div class="col-md-4">
                                            <div class="thumbnail">     
                                                <?php $pict = App\Picture::where('id', $col->pivot->pictures_id)->get(); ?>
                                                <img src='{{ asset('storage/' . $pict[0]->path . '50_50.jpg') }}' alt="...">
                                                <div class="caption">
                                                  <p class="img_caption_color">{{ $col->title }}</p>
                                                </div>
                                            </div>
                                          </div>
                                          @if ($curLoop == $myClearImg)
                                            <div class="clearfix visible-*-block"></div>
                                            <?php $myClearImg = 3;  $curLoop = 0;?>
                                          @endif
                                          <?php $curLoop++; ?>    
                                        @endif
                                        <?php $allcolor[] = $col->id; ?>
                                      @endforeach 
                                    @endforeach
                                  @endforeach
                                </div>
                                  <div class="caption">
                                      <h4>{{ $good->title }}</h4>
                                      <p>{{ $good->descriptions->title }}</p>
                                      <p>{{ $good->category->title }}</p>
                                      <p>{{ $good->subcategory->title }}</p>
                                      <p>
                                        @foreach ($good->size as $s)
                                          <ii style="color: red">{{ $s->title }}</ii>
                                          <?php $goodsSizes = App\GoodsSizes::where('id', $s->pivot->id)->get(); ?>
                                          @foreach ($goodsSizes as $goodSize)
                                            @foreach ($goodSize->color as $col)
                                              <i style="color: green">{{ $col->title }}</i>
                                            @endforeach                                           
                                          @endforeach
                                          <br>
                                        @endforeach
                                        
                                      </p>
                                        <a href="edit_tables/{{ $good->id }}" class="btn btn-primary" role="button">Редактировать</a> 
                                        <a class="btn btn-default" type="button" data-toggle="modal" data-target="#myModal{{ $good->id }}">Удалить</a>
                                       
                                        <!-- Modal -->
                                        <div class="modal fade" id="myModal{{ $good->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                          <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Удаление записи "{{ $good->title }}"</h4>
                                              </div>
                                              <div class="modal-body">
                                                <div class="row">
                                                  <div class="col-lg-12">
                                                    <div class="input-group">
                                                      <span class="input-group-addon">
                                                        <input type="checkbox" id="del_desc{{ $good->id }}" value="">
                                                      </span>
                                                      <label type="text" class="form-control" aria-label="drop_descr{{ $good->id }}">Удалить описание</label>
                                                    </div><!-- /input-group -->
                                                  </div><!-- /.col-lg-6 -->
                                                </div><!-- /.row -->
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
                                                <button id="{{ $good->id }}deleteRecord" curid="{{ $good->id }}" class="btn btn-danger">Удалить</button>
                                                <div class="alert alert-success" id="erralert{{ $good->id }}" role="alert" hidden=""></div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </p>
                                  </div>
                                </div>
                            </div>
                            @if ($loop->iteration == $myClear)
                              <div class="clearfix visible-*-block"></div>
                              <?php $myClear += 3; ?>
                            @endif
                        @endforeach
                      
                      </div>
                      <br>
                      @endforeach
                      </div>
                      @php
                        $showTables = ob_get_contents();

                        // $myecho = $showTables;
                        // `echo " showTables iter: $loop->iteration    " >>/tmp/qaz`;
                        // `echo "$myecho" >>/tmp/qaz`;

                        ob_end_clean();

                        Cache::forever('showTables'.$category->id, $showTables);
                        // Сохранение кэш-файла с контентом
                        // $fp = fopen('./cache/showTables'.$loop->iteration.'.cache', 'w');
                        // fwrite($fp, $showTables);
                        // fclose($fp);
                        
                        echo $showTables;
                      @endphp
                      @endif
                    @endforeach
                    <br>
                    <div class="btn-group" role="group" aria-label="...">
                      <a href="/insert_tables" type="button" class="btn btn-default">Добавить запись</a>
                      <a href="/show_category" type="button" class="btn btn-default">Редактировать категории</a>
                      <a href="/show_subcat" type="button" class="btn btn-default">Редактировать субкатегории</a>
                      <a href="/show_descr" type="button" class="btn btn-default">Редактировать описание</a>
                      <a href="/show_size" type="button" class="btn btn-default">Редактировать размер</a>
                      <a href="/show_color" type="button" class="btn btn-default">Редактировать цвет</a>
                      <a href="/show_pict" type="button" class="btn btn-default">Редактировать картинки</a>
                    </div>
                </div>
            </div>
            <br><br>

@endsection

{{-- @php
  $showTables = ob_get_contents();

  $myecho = $showTables;
  `echo " showTables ob_get    " >>/tmp/qaz`;
  `echo "$myecho" >>/tmp/qaz`;

  ob_end_clean();

  // Cache::forever('showTables', $showTables);
  // Сохранение кэш-файла с контентом
  $fp = fopen('./cache/showTables.cache', 'w');
  fwrite($fp, $showTables);
  fclose($fp);
  
  echo $showTables;
@endphp


@endif --}}

@section('myjs')
  {{-- <script src="/js/jquery.min.js"></script>
  <script src="/js/bootstrap.min.js"></script> --}}
  <script type="text/javascript">
    $('[id $= deleteRecord]').on('click', function () {
      id = $(this).attr('curid');
      // console.log(id);
      del_desc = $('#del_desc' + id).is(':checked');//.prop("checked");

      $.get('/delete_row', {id:id, del_desc:del_desc}, function( data ) {
        if(data.success == true){
          $('#erralert' + id).removeAttr('hidden');
          $('#erralert' + id).text(data.message);
          $(location).attr('href', '/show_tables');
        }
        else if(data.success == false){
          //alert('count= '+ data.success);
          document.getElementById('del_desc' + id).checked = false;
          del_desc = $('#del_desc' + id).is(':checked');
          $("[aria-label='drop_descr" + id + "']").text(data.message);
        }
        
      }, 'json');
    })
  </script>
@endsection



{{-- <!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/welcome.css">
        <script src="/js/jquery.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        
    </head>
    <body>
    </body> --}}
    {{-- {{$pictures}}<br><br> --}}
    {{-- {{$goodsSizes}} --}}
            
   
