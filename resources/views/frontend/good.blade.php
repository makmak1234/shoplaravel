@extends('layouts.base')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/frontend/indexUser.css')}}">
    <link rel="stylesheet" href="{{asset('css/frontend/show.css')}}">
@endsection

@section('javascripts')
    <script src="{{asset('js/frontend/indexUser.js')}}"></script>
    <script src="{{asset('js/frontend/goodsbasketcheck.js')}}"></script>
    <script src="{{asset('js/frontend/select_visible.js')}}"></script>
    <script src="{{asset('js/frontend/hinclude.js')}}"></script>
@endsection

        <div class="bubblingG">
            <span id="bubblingG_1">
            </span>
            <span id="bubblingG_2">
            </span>
            <span id="bubblingG_3">
            </span>
        </div>  

    @section('content')
        <div class="content">
            <div class="container">

                <div class="slogan">
                    <h1>Заголовок</h1>
                </div> 
                <div class="bread-crumbs"><a href="{{ route('index') }}">Все категории</a>-> 
                    <a href="{{ route('cat_sub_show', ['cat_id'=>$good->categories_id , 'subcat_id'=>$good->categories_id  ]) }}">{{ $good->category->title }}</a>->  
                    {{ $good->subcategory->title }}
                </div>

                <div class="row">
                  <div class="col-sm-6 col-md-6">
                    <div class="thumbnail"> 
                        <select name="size" id="size" onChange="sizeSelect(this)" >
                            @foreach ($good->size as $s)
                                <option value="{{ $s->title }}">{{ $s->title }}</option>
                            @endforeach 
                        </select>

                        @foreach ($good->size as $s)
                            <?php $goodsSizes = App\GoodsSizes::where('id', $s->pivot->id)->get(); 
                                    $goodSize = $goodsSizes[0];
                            ?>
                            <select name="$s->title" id="{{ 'color' . $loop->index }}" style="display: none;" onChange="colorSelect(this)">
                                @foreach ($goodSize->color as $col)
                                  <option value="{{ $col->title }}">{{ $col->title }} </option>
                                @endforeach                                           
                            </select>
                                @foreach ($goodSize->color as $col)
                                    <?php $pict = App\Picture::where('id', $col->pivot->pictures_id)->get(); ?>
                                    <div id="{{ 'image' . $loop->parent->index . $loop->index }}" style="display: none;">
                                        <img class="show__img" src='{{ asset('storage/' . $pict[0]->path) }}' alt="...">
                                    </div>
                                @endforeach                                           
                        @endforeach
                        
                      <div class="caption">
                        <h3>{{ $good->title }}</h3>
                        <p>{{ $good->descriptions->title }}</p>
                        <p>price</p>
                        <p class="onerow">
                            <i id="fountainIncart">
                                <i id="fountainG_1" class="fountainG"></i>
                                <i id="fountainG_2" class="fountainG"></i>
                                <i id="fountainG_3" class="fountainG"></i>
                                <i id="fountainG_4" class="fountainG"></i>
                                <i id="fountainG_5" class="fountainG"></i>
                                <i id="fountainG_6" class="fountainG"></i>
                                <i id="fountainG_7" class="fountainG"></i>
                                <i id="fountainG_8" class="fountainG"></i>
                            </i>
                            <button class="btn btn-primary" role="button" onclick="goodbuycheck({{ $good->id }}, 'false', 'ajax_bag_user')">Купить</button>
                            <button class="btn btn-default" onclick="goodbasketcheck({{ $good->id }}, 'false', 'ajax_bag_user')">В корзину</button>
                        </p>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-6 col-md-6">
                    <div id="bascetsmall" class="bascetsmall">
                        {{-- ВКЛЮЧИТЬ ПОЗЖЕ КОРЗИНУ {{ render_esi(controller('UserBundle:ajaxUser:ajaxBagUser',
                            { 'id': 0})) }} --}}
                    </div>
                  </div>

                </div>   

            </div>
        </div>

    @endsection