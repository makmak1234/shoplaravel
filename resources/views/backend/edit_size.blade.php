@extends('layouts.app')

@section('mycss')
  {{-- <link rel="stylesheet" href="/css/bootstrap.min.css"> --}}
  {{-- <link rel="stylesheet" href="/css/welcome.css"> --}}
@endsection

@section('content')
        <form method="POST" action="/store_edit_size">
            {{ csrf_field() }}
            <input type="text" class="form-control" name="en" value="{{ $size->en }}" placeholder="en">
            <input type="text" class="form-control" name="ru" value="{{ $size->ru }}" placeholder="ru">
            <input type="hidden" name="id" value="{{ $size->id }}">
            <button type="send">Готово</button>
        </form>
@endsection