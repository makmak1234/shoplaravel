
@include('frontend.smallBag')

@if($bigBagDisp == 'block') 
    <table class="goodsbasketfont m-cart-full">
		<tr><td colspan= "7">@lang('Your cart'):</td></tr>
		<tr>
			<th>@lang('Good')</th>
			<th>@lang('Size')</th>
			<th>@lang('Color')</th>
			<th>@lang('One of Price')</th>
			<th>@lang('Count')</th>
			<th>@lang('All of Price')</th>
			<th> </th>
		</tr>

		@foreach($goods as $good)
		<tr class="onerow">
			<td>{{ $good->$language }}</td>
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
		<tr><td colspan= "7">@lang('To Pay'): {{ $priceall }}</td></tr>
		<tr>
			<td colspan= "4"><a type="button" class="btn btn-default buylab" href="{{ route('bag_register_secure') }}">@lang('Registration')</a></td>
			<td colspan= "3"><button type="button" class="btn btn-default" onclick="goodbasketcheck('-1', 'false', 'ajax_bag_user')">@lang('Clear cart')</button></td>
		</tr>
	</table>
@endif

