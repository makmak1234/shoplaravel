@extends('layouts.base')

@section('stylesheets')
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/frontend/indexUser.css')}}">
    <link rel="stylesheet" href="{{asset('css/frontend/showSubcat.css')}}">
@endsection

@section('javascripts')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{asset('js/frontend/indexUser.js')}}"></script>
@endsection

{{-- ВКЛЮЧИТЬ ПОЗЖЕ КОРЗИНУ {{ render_esi(controller('UserBundle:indexUser:smallBag')) }} {#, { 'nidAll': nidAll }#}
  --}}

    @section('content')
        <div class="content">
            <div class="container">
                <div class="slogan">
                    <h1>Заголовок</h1>
                </div> 
                <div class="bread-crumbs"><a href="{{ route('index') }}">Все категории</a>->
                    {{ $goods[0]->category->title }}-> 
                    {{ $goods[0]->subcategory->title }}   
                </div>
                <div class="row">
                    @foreach ($goods as $good)
                        @php   
                            $idDiv = "category" . $loop->index;
                        @endphp
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="card">
                                <h4>{{ $good->title }}</h4>
                                <div id='{{ $idDiv }}' class="category" style="background-image: url({{ asset('storage/' . $picts[$loop->index]) }});">
                                    <a class="a-card" href="{{ route('good', ['cat'=>$good->categories_id , 'subcat'=>$good->subcategories_id, 'id'=>$good->id ]) }}">
                                        <div>
                                            <b>Название:</b>{{ $good->title }}
                                            <br>
                                            <b>Описание:</b> {{ $good->description }}
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @section('nav')
                    @include('frontend/common_nav')
                @endsection
            </div>
        </div>
    @endsection
