
@if($nidAll > 0)
	<div class="goodsbasketfontmb bascetsmall">
        <i id="fountainSmall" >
            <i id="fountainG_1" class="fountainG"></i>
            <i id="fountainG_2" class="fountainG"></i>
            <i id="fountainG_3" class="fountainG"></i>
            <i id="fountainG_4" class="fountainG"></i>
            <i id="fountainG_5" class="fountainG"></i>
            <i id="fountainG_6" class="fountainG"></i>
            <i id="fountainG_7" class="fountainG"></i>
            <i id="fountainG_8" class="fountainG"></i>
        </i>
		<img src="{{ asset('storage/img/delete_16x16.png')}}" class="goodsbasketclearmb" onclick="goodbasketcheck('-1', 'false', 'ajax_bag_user')" title="@lang('Clear cart')">
		<table class="m-cart-fullmb" title="@lang('Ordering')">
			<tr>
				<td><a class="a-block" href="{{ route('bag_register_secure') }}">@lang('Cart'): <span id='nidAll'>{{ $nidAll }}</span> @lang('PC.')</a><td>
			</tr>
		</table>
	</div>
@endif