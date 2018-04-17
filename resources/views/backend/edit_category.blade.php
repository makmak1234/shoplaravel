@extends('layouts.app')

@section('mycss')
  {{-- <link rel="stylesheet" href="/css/bootstrap.min.css"> --}}
  {{-- <link rel="stylesheet" href="/css/welcome.css"> --}}
@endsection

@section('content')
        {{-- <form method="POST" action="/store_edit_category" ENCTYPE="multipart/form-data">
            {{ csrf_field() }}
            <input type="text" class="form-control" name="title" value="{{ $category->title }}">
            <input type="hidden" name="id" value="{{ $category->id }}">             
                <input id="file-input_" name="pict" type="file">
                Добавить картинку
            <button type="send">Готово</button>
        </form> --}}

    <div class="row">
              <div class="col-md-4 col-sm-6 col-xs-12">
                  <div class="thumbnail">
                      <img src="{{ asset('storage/' . $category->path) }}" alt="...">
                      <div class="caption">
                          <p>{{ $category->en }}</p>
                          <p>{{ $category->ru }}</p>
                          <p>
                            {{-- <a href="edit_color/{{ $pict->id }}" class="btn btn-primary" role="button">Редактировать</a>  --}}

                             <form method="POST" action="/store_edit_category" enctype="multipart/form-data" >
                                {{ csrf_field() }}
                                <input type="text" class="form-control" name="en" value="{{ $category->en }}" placeholder="en">
                                <input type="text" class="form-control" name="ru" value="{{ $category->ru }}" placeholder="ru">
                                <input type="file" class="form-control" name="pict" value="">
                                <input type="hidden" name="id" value="{{ $category->id }}">
                                <button type="send">Готово</button>
                            </form>
                             
                          </p>
                      </div>
                  </div>
              </div>
      </div>
@endsection