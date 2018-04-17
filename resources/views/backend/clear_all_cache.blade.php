@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="container">
            <div class="slogan">
                <h1>Кеш стерт</h1>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <a href="{{route('showTables')}}" type="button" class="btn btn-default" data-dismiss="modal">Вернуться</a>
                </div>
            </div>
        </div>
    </div>
@endsection