@extends('layouts.app')

@section('mycss')
  {{-- <link rel="stylesheet" href="/css/bootstrap.min.css"> --}}
  {{-- <link rel="stylesheet" href="/css/welcome.css"> --}}
@endsection

@section('content')

        <div class="row">
              <div class="col-md-4 col-sm-6 col-xs-12">
                  <div class="thumbnail">
                      <img src="{{ asset('storage/' . $pict->path) }}" alt="...">
                      <div class="caption">
                          <p>{{ $pict->title }}</p>
                          <p>
                            {{-- <a href="edit_color/{{ $pict->id }}" class="btn btn-primary" role="button">Редактировать</a>  --}}

                             <form method="POST" action="/store_edit_pict" ENCTYPE="multipart/form-data">
                              {{ csrf_field() }}
                              <input type="file" class="form-control" name="pict" value="">
                              <input type="hidden" name="id" value="{{ $pict->id }}">
                              <button type="send">Готово</button>
                            </form>
                             
                          </p>
                      </div>
                  </div>
              </div>
      </div>
@endsection