@extends('layouts.base')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/frontend/indexUser.css')}}">
@endsection

@section('javascripts')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{asset('js/frontend/indexUser.js')}}"></script>
@endsection

    {{-- ВКЛЮЧИТЬ ПОЗЖЕ КОРЗИНУ {{ render_esi(controller('UserBundle:indexUser:smallBag')) }}  --}}
    @inject('smallBag', 'App\Http\Controllers\Frontend\indexController')
    {{ $smallBag->smallBagAction() }}

   @section('content')
        <div class="content">
            <div class="container">
                <div class="slogan">
                    <h1>Заголовок</h1>
                </div> 
                <div class="bread-crumbs">Все категории</div>
                <div class="row">       
                    @foreach ($categories as $category)  
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="card">
                                <h4>{{ $category->title }}</h4>
                                <div id='{{ "category" . $loop->index }}' class="category" style="background-image: url({{ asset('storage/' . $category->path) }});">
                                    @php $subcats = $category->subcategory; @endphp
                                    @foreach ($subcats as $subcat)
                                        @php 
                                          $goods = App\Goods::where([
                                              ['categories_id', '=', $category->id],
                                              ['subcategories_id', '=', $subcat->id],
                                          ])->get();
                                        @endphp
                                        <a class="a-card" href="{{  route('cat_sub_show', ['cat_id'=> $category->id, 'subcat_id'=> $subcat->id]) }}">{{ $subcat->title }}</a>
                                        <br> 
                                    @endforeach
                                    <br>
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


