@extends('layouts.base')

@section('body')

	<center style='font: 1.5em italic; color:#006600;'><a href="{{ route('index') }}">Вернуться в магазин</a></center>
	<center style="font-size:1.5em; color:#669900;"><br>Спасибо! Заказ принят. В ближайшее время с вами свяжется наш менеджер</center> 
	<center style='font-size:1.5em; color:#669900;'><br>Ваш номер заказа: <div style='font-size:2.5em; color:red;'> {{ $order }}</div></center>

@endsection

