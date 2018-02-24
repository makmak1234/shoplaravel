@extends('layouts.base')

@section('stylesheets')
    {{-- <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"> --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/frontend/indexUser.css')}}">
    <link rel="stylesheet" href="{{asset('css/frontend/showSubcat.css')}}">
    <link rel="stylesheet" href="{{asset('css/frontend/smallBag.css')}}">
@endsection

@section('javascripts')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{asset('js/frontend/indexUser.js')}}"></script>
    <script src="{{asset('js/routes.js')}}"></script>
    <script src="{{asset('js/frontend/goodsbasketcheck.js')}}"></script>
@endsection

    @section('small_bag')
        {{-- ВКЛЮЧИТЬ ПОЗЖЕ КОРЗИНУ {{ render_esi(controller('UserBundle:indexUser:smallBag')) }}  --}}
        @inject('smallBag', 'App\Http\Controllers\Frontend\IndexController')
        {!! $smallBag->smallBagAction() !!}
    @endsection

    @section('content')
        <div class="content">
            <div class="container">
                @if (Cache::has($catSubcat)) 
                    @php
                      $indexSubcat = Cache::get($catSubcat);
                      echo $indexSubcat;
                    @endphp
                @else
                    @php 
                        ob_start();
                    @endphp  
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

                    @php
                        $indexSubcat = ob_get_contents();

                        ob_end_clean();

                        Cache::forever($catSubcat, $indexSubcat);
                        
                        // $myecho = $index;
                        // `echo " index :  " >>/tmp/qaz`;
                        // `echo "$myecho" >>/tmp/qaz`;

                        echo $indexSubcat;
                    @endphp
                @endif 

                @section('nav')
                    @include('frontend/common_nav')
                @endsection
            </div>
        </div>
    @endsection
