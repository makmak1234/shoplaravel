<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <script src="/js/jquery.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        
    </head>
    <body>
    {{-- {{$goods}}<br><br>
    {{$goodsSizes}} --}}
            <div class="content">
                <div class="container">
                    <div class="slogan">
                        <h1>Заголовок</h1>
                    </div> 
                    <div class="bread-crumbs">Все категории</div>
                    <div class="row">
                        @foreach ($goods as $good)
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="thumbnail">
                                    <img src="..." alt="...">
                                    <div class="caption">
                                        <h4>{{ $good->title }}</h4>
                                        <p>{{ $good->descriptions->title }}</p>
                                        <p>
                                          @foreach ($good->size as $s)
                                            <ii style="color: red">{{ $s->title }}</ii>
                                            <?php $g = $good->size; ?>
                                            {{-- {{$g}} --}}
                                            {{-- {{$g[1]->id}}
                                            {{$g[2]->id}} --}}
                                            {{-- {{ $s->pivot->id}} --}}
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
                                                          <label type="text" class="form-control" aria-label="drop_descr">Удалить описание</label>
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
                        @endforeach
                    </div>
                    <br>
                    <div class="btn-group" role="group" aria-label="...">
                      <a href="/insert_tables" type="button" class="btn btn-default">Добавить запись</a>
                      <a href="/show_descr" type="button" class="btn btn-default">Редактировать описание</a>
                      <a href="/show_size" type="button" class="btn btn-default">Редактировать размер</a>
                      <a href="/show_color" type="button" class="btn btn-default">Редактировать цвет</a>
                      <a href="/show_pict" type="button" class="btn btn-default">Редактировать картинки</a>
                    </div>
                </div>
            </div>

       <!--  </div> -->

    </body>

    <script type="text/javascript">
      $('[id $= deleteRecord]').on('click', function () {
        id = $(this).attr('curid');
        //alert('id= '+id);
        del_desc = $('#del_desc' + id).is(':checked');//.prop("checked");

        $.get('/delete_row', {id:id, del_desc:del_desc}, function( data ) {
          if(data.success == true){
            $('#erralert' + id).removeAttr('hidden');
            $('#erralert' + id).text(data.message);
            $(location).attr('href', '/');
          }
          else if(data.success == false){
            //alert('count= '+ data.success);
            document.getElementById('del_desc' + id).checked = false;
            del_desc = $('#del_desc' + id).is(':checked');
            $("[aria-label='drop_descr']").text(data.message);
          }
          
        }, 'json');
      })
    </script>
   
</html>
