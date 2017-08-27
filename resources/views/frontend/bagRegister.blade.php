@extends('layouts.base')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/checkoutBag.css')}}">
@endsection

@section('javascripts')
    <script src="{{asset('js/frontend/goodsbasketcheck.js')}}"></script>
@endsection

@section('body')
    <div class="container">

        <div id="bascetsmall" class="bascetsmall">
            {{-- {{ render(controller('UserBundle:ajaxUser:ajaxCheckoutUser', { 'id': id, bagreg: false} )) }} --}}
            @inject('ajaxCheckoutUser', 'App\Http\Controllers\Frontend\ajaxUserController')
            {{ $ajaxCheckoutUser->ajaxCheckoutUserAction($good->id, false) }}
        </div>


        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 userform">
            <h4>Оформление заказа</h4>
            <form method="POST" action="/store_color">
                {{ csrf_field() }}
                <div class="input-group myinput">    
                    <span class="input-group-addon glyphicon glyphicon-user"></span>
                    <input type="input" name="name" class="form-control", placeholder="Имя" />
                </div>
                <div class="input-group myinput">
                    <span class="input-group-addon glyphicon glyphicon-home"></span>
                    <input type="input" name="city" class="form-control", placeholder="Город" />
                </div>
                <div class="input-group myinput">
                    <span class="input-group-addon glyphicon glyphicon-earphone"></span>
                    <input type="input" name="tel" class="form-control", placeholder="Телефон" />
                </div>
                <div class="input-group myinput">
                    <span class="input-group-addon  glyphicon glyphicon-comment"></span>
                    <input type="input" name="tel" class="form-control", rows=3, placeholder="Комментарий" />
                </div>

                <input type="hidden" name="back_shop" value="id" />

                <button type="submit" class="btn btn-success" value="Готово" onclick="document.bag_register.back_shop.value=false;">Готово</button>

                <button type="submit" class="btn btn-default inp_contin" value="Продолжить покупки" formnovalidate onclick="document.bag_register.back_shop.value=true;">Продолжить покупки</button>

            </form>
        </div>
    </div>
@endsection
