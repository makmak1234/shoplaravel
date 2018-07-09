@extends('layouts.base')

@section('body')

	<center style='font: 1.5em italic; color:#006600;'><a href="{{ route('index') }}">@lang('Back to Shop')</a></center>
	<center style="font-size:1.5em; color:#669900;"><br>@lang('Thank you! Order is accepted. In the near future our manager will contact you')</center> 
	<center style='font-size:1.5em; color:#669900;'><br>@lang('Your Order'): <div style='font-size:2.5em; color:red;'> {{ $order }}</div></center>

@endsection

