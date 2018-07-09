

@if($bigBagDisp == 'block') 
	
		<div class="panel panel-default">
		  <!-- Default panel contents -->
		  <div class="panel-heading">@lang('Your purchases')</div>
		    <table class="table goodsbasketfont m-cart-full">
				<tr>
					<th>@php echo count($childrenGoods); @endphp</th>
					<th>@lang('Good')</th>
					<th class="hide_col1">@lang('Size')</th>
					<th class="hide_col1">@lang('Color')</th>
					<th class="hide_col1">@lang('One of Price')</th>
					<th>@lang('Count')</th>
					<th class="hide_col2">@lang('All of Price')</th>
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
				<!--tr><td colspan= "8" id="priceall">@lang('To Pay'): {{ $priceall }}</td></tr-->
                <tr>
                    <td><b>@lang('To Pay'):</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b id="priceall">{{ $priceall }}</b></td>
                    <td></td>
                </tr>
				
			</table>
		</div>
	
@else
	Корзина пустая 
	<script>
		route = Router.route('index');
		window.location.href = route;
	</script>
@endif