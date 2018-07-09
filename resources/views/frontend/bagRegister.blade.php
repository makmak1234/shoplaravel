@extends('layouts.base')

@section('stylesheets')
    @parent
    {{-- <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"> --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/frontend/checkoutBag.css')}}">
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> --}}
@endsection

@section('javascripts')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{asset('js/routes.js')}}"></script>
    <script src="{{asset('js/frontend/goodsbasketcheck.js')}}"></script>
@endsection

@section('header')
@endsection

@section('content')
    <div class="container">

        <div id="bascetsmall" class="bascetsmall">
            {{-- {{ render(controller('UserBundle:ajaxUser:ajaxCheckoutUser', { 'id': id, bagreg: false} )) }} --}}
            @inject('ajaxCheckoutUser', 'App\Http\Controllers\Frontend\ajaxUserController')
            {!! $ajaxCheckoutUser->ajaxCheckoutUserAction($id, false) !!}
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 userform">
            <h4>@lang('Ordering')</h4>
            <form method="POST" action="{{ route('bag_register_store') }}" name="bag_register">
                {{ csrf_field() }}
                <div class="input-group myinput">    
                    <span class="input-group-addon glyphicon glyphicon-user"></span>
                    <input type="input" name="name" class="form-control", placeholder="@lang('Name')" value="{{ $name }}"/>
                </div>
                <div class="input-group myinput">
                    <span class="input-group-addon glyphicon glyphicon-home"></span>
                    <input type="input" name="city" class="form-control", placeholder="@lang('City')" value="{{ $city }}"/>
                </div>
                <div class="input-group myinput">
                    <span class="input-group-addon glyphicon glyphicon-earphone"></span>
                    <input type="input" name="tel" class="form-control", placeholder="@lang('Phone')" value="{{ $tel }}"/>
                </div>
                <div class="input-group myinput">
                    <span class="input-group-addon  glyphicon glyphicon-comment"></span>
                    <input type="input" name="comment" class="form-control", rows=3, placeholder="@lang('Comment')" value="{{ $comment }}"/>
                </div>

                <input type="hidden" name="back_shop" value="id" />

                <button type="submit" class="btn btn-success" value="Готово" onclick="document.bag_register.back_shop.value=false;">@lang('Accept')</button>

                <button type="submit" class="btn btn-default inp_contin" value="Продолжить покупки" formnovalidate onclick="document.bag_register.back_shop.value=true;">@lang('Continue purchases')</button>

            </form>
        </div>
    </div>
@endsection

@section('footer')
@endsection