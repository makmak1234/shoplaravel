@extends('layouts.app')

@section('mycss')
  {{-- <link rel="stylesheet" href="/css/bootstrap.min.css"> --}}
  {{-- <link rel="stylesheet" href="/css/welcome.css"> --}}
@endsection

@section('content')
            <div class="content">
                <div class="container">
                    <div class="slogan">
                        <h1>Описание</h1>
                    </div> 
                    <div class="bread-crumbs">Описание</div>
                    <div class="row">
                        @foreach ($descrs as $descr)
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="thumbnail">
                                    <div class="caption">
                                        <p>{{ $descr->title }}</p>
                                        <p>
                                            <a href="edit_descr/{{ $descr->id }}" class="btn btn-primary" role="button">Редактировать</a> 
                                            <a class="btn btn-default" type="button" data-toggle="modal" data-target="#myModal{{ $descr->id }}">Удалить</a>
                                           
                                            <!-- Modal -->
                                            <div class="modal fade" id="myModal{{ $descr->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                              <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Удаление записи "{{ $descr->title }}"</h4>
                                                  </div>
                                                  <div class="modal-body">
                                                    <div class="row">
                                                      <div class="col-lg-12">
                                                        <div class="input-group">
                                                          <span class="input-group-addon">
                                                            <input type="checkbox" id="del_desc{{ $descr->id }}" value="">
                                                          </span>
                                                          <label type="text" class="form-control" aria-label="drop_descr">Удалить описание</label>
                                                        </div><!-- /input-group -->
                                                      </div><!-- /.col-lg-6 -->
                                                    </div><!-- /.row -->
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
                                                    <button id="{{ $descr->id }}deleteRecord" curid="{{ $descr->id }}" class="btn btn-danger">Удалить</button>
                                                    <div class="alert alert-success" id="erralert{{ $descr->id }}" role="alert" hidden=""></div>
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
                      <a href="/insert_descr" type="button" class="btn btn-default">Добавить запись</a>
                      <a href="{{route('showTables')}}" type="button" class="btn btn-default">Назад к товару</a>
                    </div>
                </div>
            </div>

@endsection

@section('myjs')
    <script type="text/javascript">
      $('[id $= deleteRecord]').on('click', function () {
        id = $(this).attr('curid');
        
        del_desc = $('#del_desc' + id).is(':checked');//.prop("checked");
        //alert('id= '+id + '  del_desc= ' + del_desc);
        $.get('/delete_descr', {id:id, del_desc:del_desc}, function( data ) {
          if(data.success == true){
            $('#erralert' + id).removeAttr('hidden');
            $('#erralert' + id).text(data.message);
            $(location).attr('href', '/show_descr');
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
