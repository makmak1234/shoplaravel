

@if($bigBagDisp == 'block') 
	
		<div class="panel panel-default">
		  <!-- Default panel contents -->
		  <div class="panel-heading">Ваши покупки</div>
		    <table class="table goodsbasketfont m-cart-full">
				<tr>
					<th>@php echo count($childrenGoods); @endphp</th>
					<th>Товар</th>
					<th class="hide_col1">Размер</th>
					<th class="hide_col1">Цвет</th>
					<th class="hide_col1">Цена за ед</th>
					<th>Кол-во</th>
					<th class="hide_col2">Цена за все</th>
					<th></th>
				</tr>
				@foreach($childrenGoods as $childrenGood)
					@php $idtr = "idtr" . $loop->index;
						$idrow2 = "idrow2" . $loop->index;
						$idnidk = "idnidk" . $loop->index;
						$idrowk = "idrowk" . $loop->index;
					@endphp

				<tr id="{{ $idtr }}" class="onerow">

					<td>
						<img class="show__img" src="{{ asset($sourcePath[$loop->index]) }}">
					</td>
					<td class="title">{{ $childrenGood->$language }}</td>
					<td class="hide_col1">
						{{ $sizeTitle[$loop->index] }}
					</td>
					<td class="hide_col1">
						{{ $colorTitle[$loop->index] }}
					</td>
					
					<td class="hide_col1" id="{{ $idrow2 }}">{{ 100 }}</td>
					
					<td id="{{ $idnidk }}"><input type="number" min="1" max="99" size="3" name="numbergoods" value="{{ $nid[$loop->index] }}" onchange="basketbigchange({{ 100 }}, this.value, {{ $loop->index }}, @php echo count($childrenGoods); @endphp)"/></td>
					
					<td class="hide_col2" id="{{ $idrowk }}">{{ $priceone[$loop->index] }}</td>
					<td>
						<i id="fountainCheck" class="fountainG{{ $childrenGood->id }}{{ $sizearr[$loop->index] }}{{ $colorarr[$loop->index]}}"  data-fountain>
							<i id="fountainG_1" class="fountainG"></i>
							<i id="fountainG_2" class="fountainG"></i>
							<i id="fountainG_3" class="fountainG"></i>
							<i id="fountainG_4" class="fountainG"></i>
							<i id="fountainG_5" class="fountainG"></i>
							<i id="fountainG_6" class="fountainG"></i>
							<i id="fountainG_7" class="fountainG"></i>
							<i id="fountainG_8" class="fountainG"></i>
						</i>
						<img id="good_click_id" class="del_click" src="{{ asset('storage/img/delete_16x16.png')}}" onclick="goodbasketdel({{ $childrenGood->id }}, {{ $sizearr[$loop->index] }}, {{ $colorarr[$loop->index] }}, 'true', 'ajax_checkout_user')">
					</td>
				</tr>		
				@endforeach
				<tr><td colspan= "8" id="priceall">К оплате: {{ $priceall }}</td></tr>
				
			</table>
		</div>
	
@else
	Корзина пустая 
	<script>
		route = Router.route('index');
		window.location.href = route;
	</script>
@endif