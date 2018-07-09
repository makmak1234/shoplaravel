@extends('layouts.base')

    @section('stylesheets')
        @parent
        {{-- <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"> --}}
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="{{asset('css/frontend/indexUser.css')}}">
        <link rel="stylesheet" href="{{asset('css/frontend/smallBag.css')}}">
    @endsection

    @section('javascripts')
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{asset('js/routes.js')}}"></script>
        <script src="{{asset('js/frontend/indexUser.js')}}"></script>
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
                    <div class="slogan">
                        <h1>@lang('Heading')</h1>
                        {{-- {{ $pass }} --}}
                    </div> 
                    <div class="bread-crumbs">@lang('All categories')</div>
                    <div class="row"> 
                        @if (Cache::has('index_'.$language)) 
                            @php
                              $index = Cache::get('index_'.$language);
                              echo $index;
                            @endphp
                        @else
                            @php 
                                ob_start();
                            @endphp    
                            @foreach ($categories as $category)  
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="card">
                                        <h4>{{ $category->$language }}</h4>
                                        <div id='{{ "category" . $loop->index }}' class="category" style="background-image: url({{ asset('storage/' . $category->path) }});">
                                            @php $subcats = $category->subcategory; @endphp
                                            @foreach ($subcats as $subcat)
                                                @php 
                                                  $goods = App\Goods::where([
                                                      ['categories_id', '=', $category->id],
                                                      ['subcategories_id', '=', $subcat->id],
                                                  ])->get();
                                                @endphp
                                                <a class="a-card" href="{{  route('cat_sub_show', ['cat_id'=> $category->id, 'subcat_id'=> $subcat->id]) }}">{{ $subcat->$language }}</a>
                                                <br> 
                                            @endforeach
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @php
                                $index = ob_get_contents();

                                ob_end_clean();

                                Cache::forever('index_'.$language, $index);
                                
                                // $myecho = $index;
                                // `echo " index :  " >>/tmp/qaz`;
                                // `echo "$myecho" >>/tmp/qaz`;

                                echo $index;
                            @endphp
                        @endif    
                    </div>
                    @section('nav')
                        @include('frontend/common_nav')
                    @endsection
                </div>
            </div>
    @endsection

    


