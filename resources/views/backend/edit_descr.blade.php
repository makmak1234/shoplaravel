@extends('layouts.app')

@section('mycss')
  {{-- <link rel="stylesheet" href="/css/bootstrap.min.css"> --}}
  {{-- <link rel="stylesheet" href="/css/welcome.css"> --}}
@endsection

@section('content')
        <form method="POST" action="/store_edit_descr">
            {{ csrf_field() }}
            <input type="text" class="form-control" name="en" value="{{ $descr->en }}" placeholder="en">
            <input type="text" class="form-control" name="ru" value="{{ $descr->ru }}" placeholder="ru">
            <input type="hidden" name="id" value="{{ $descr->id }}">
            <button type="send">Готово</button>
        </form>
@endsection