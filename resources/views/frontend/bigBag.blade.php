
@include('frontend.smallBag')

@if($bigBagDisp == 'block') 
    <table class="goodsbasketfont m-cart-full">
		<tr><td colspan= "7">Ваша корзина:</td></tr>
		<tr>
			<th>Товар</th>
			<th>Размер</th>
			<th>Цвет</th>
			<th>Цена за ед</th>
			<th>Кол-во</th>
			<th>Цена за все</th>
			<th> </th>
		</tr>

		@foreach($goods as $good)
		<tr class="onerow">
			<td>{{ $good->title }}</td>
			<td>
				{{ $sizeTitle[$loop->index] }}
			</td>
			<td>
				{{ $colorTitle[$loop->index] }}
			</td>
			<td>{{ 100 }}</td> {{-- $good->price->rub --}}
			<td>{{ $nid[$loop->index] }}</td>
			<td>{{ $priceone[$loop->index] }}</td>
			<td>
				<i id="fountainG" class="fountainG{{ $good->id }}{{ $sizearr[$loop->index] }}{{ $colorarr[$loop->index]}}"  data-fountain>
					<i id="fountainG_1" class="fountainG"></i>
					<i id="fountainG_2" class="fountainG"></i>
					<i id="fountainG_3" class="fountainG"></i>
					<i id="fountainG_4" class="fountainG"></i>
					<i id="fountainG_5" class="fountainG"></i>
					<i id="fountainG_6" class="fountainG"></i>
					<i id="fountainG_7" class="fountainG"></i>
					<i id="fountainG_8" class="fountainG"></i>
				</i>
				<img class="goodsbasketclearone" id="good_click_id" src="{{ asset('storage/img/delete_16x16.png')}}" onclick="goodbasketdel({{ $good->id }}, {{ $sizearr[$loop->index] }}, {{ $colorarr[$loop->index] }}, 'true', 'ajax_bag_user')">
			</td>
		</tr>		
		@endforeach
		<tr><td colspan= "7">К оплате: {{ $priceall }}</td></tr>
		<tr>
			<td colspan= "4"><a type="button" class="btn btn-default buylab" href="{{ route('bag_register_secure') }}">Оформить</a></td>
			<td colspan= "3"><button type="button" class="btn btn-default" onclick="goodbasketcheck('-1', 'false', 'ajax_bag_user')">Очистить корзину</button></td>
		</tr>
	</table>
@endif

