@extends('layouts.app')

@section('mycss')
  {{-- <link rel="stylesheet" href="/css/bootstrap.min.css"> --}}
  {{-- <link rel="stylesheet" href="/css/welcome.css"> --}}
@endsection

@section('content')
        <form method="POST" action="/store_edit_color">
            {{ csrf_field() }}
            <input type="text" class="form-control" name="en" value="{{ $color->en }}" placeholder="en">
            <input type="text" class="form-control" name="ru" value="{{ $color->ru }}" placeholder="ru">
            <input type="hidden" name="id" value="{{ $color->id }}">
            <button type="send">Готово</button>
        </form>
@endsection