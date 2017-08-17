@extends('layouts.app')

@section('mycss')
  {{-- <link rel="stylesheet" href="/css/bootstrap.min.css"> --}}
  {{-- <link rel="stylesheet" href="/css/welcome.css"> --}}
@endsection

@section('content')
        <form method="POST" action="/store_edit_size">
            {{ csrf_field() }}
            <input type="text" class="form-control" name="title" value="{{ $size->title }}">
            <input type="hidden" name="id" value="{{ $size->id }}">
            <button type="send">Готово</button>
        </form>
@endsection