@extends('layouts.app')

@section('mycss')
  {{-- <link rel="stylesheet" href="/css/bootstrap.min.css"> --}}
  {{-- <link rel="stylesheet" href="/css/welcome.css"> --}}
@endsection

@section('content')
            <div class="content">
                <div class="container">
                    <div class="slogan">
                        <h1>Картинки</h1>
                    </div> 
                    <div class="bread-crumbs">Картинки</div>
                    <div class="row">
                        @foreach ($picts as $pict)
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="thumbnail">
                                    <img src="{{ asset('storage/' . $pict->path) }}" alt="...">
                                    <div class="caption">
                                        <p>{{ $pict->title }}</p>
                                        <p>
                                            <a href="edit_pict/{{ $pict->id }}" class="btn btn-primary" role="button">Редактировать</a>
                                            <form method="POST" action="/store_edit_pict" ENCTYPE="multipart/form-data">
                                              {{ csrf_field() }}
                                              <label class="btn btn-primary" title="Кликни для замены">
                                                <input style="display: none" name="pict" type="file" onchange="submit()">
                                                Заменить картинку {{ $nocache }}
                                              </label>
                                              <input type="hidden" name="id" value="{{ $pict->id }}">
                                              <input type="hidden" name="nocache" value="{{ $nocache }}">
                                            </form>
                                            <br> 
                                            <a class="btn btn-default" type="button" data-toggle="modal" data-target="#myModal{{ $pict->id }}">Удалить</a>
                                           
                                            <!-- Modal -->
                                            <div class="modal fade" id="myModal{{ $pict->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                              <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Удаление записи "{{ $pict->title }}"</h4>
                                                  </div>
                                                  <div class="modal-body">
                                                    <div class="row">
                                                      <div class="col-lg-12">
                                                        <div class="input-group">
                                                          <span class="input-group-addon">
                                                            <input type="checkbox" aria-label="del_descr" value="1">
                                                            <input type="hidden" aria-label="id" value="{{ $pict->id }}">
                                                          </span>
                                                          <label type="text" class="form-control" aria-label="...">Удалить описание</label>
                                                        </div><!-- /input-group -->
                                                      </div><!-- /.col-lg-6 -->
                                                    </div><!-- /.row -->
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
                                                    <button id="{{ $pict->id }}deleteRecord" curid="{{ $pict->id }}" class="btn btn-danger">Удалить</button>
                                                    <div class="alert alert-success" id="erralert{{ $pict->id }}" role="alert" hidden=""></div>
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
                      {{-- <a href="/insert_pict" type="button" class="btn btn-default">Добавить запись</a> --}}
                      <label class="btn btn-primary" title="Кликни чтобы добавить">
                        <form method="POST" action="/store_pict" ENCTYPE="multipart/form-data">
                          {{ csrf_field() }}
                          
                            <input style="display: none" name="pict" type="file" onchange="submit()">
                            Добавить картинку
                          
                        </form>
                      </label>
                      <a href="/" type="button" class="btn btn-default">Назад к товару</a>
                    </div>
                </div>
            </div>
@endsection

@section('myjs')
    <script type="text/javascript">
      $('[id $= deleteRecord]').on('click', function () {
        id = $(this).attr('curid');
        //alert('id= '+id);
        del_desc = $('#del_desc' + id).is(':checked');//.prop("checked");

        $.get('/delete_pict', {id:id, del_desc:del_desc}, function( data ) {
          if(data.success == true){
            $('#erralert' + id).removeAttr('hidden');
            $('#erralert' + id).text(data.message);
            $(location).attr('href', '/show_pict');
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
@endsection
