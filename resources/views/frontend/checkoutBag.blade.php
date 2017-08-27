{#ajaxUserController#}

{% block javascripts %}
        <script src="{{ asset('bundles/fosjsrouting/js/router.js') }}"></script>
        <script src="{{ path('fos_js_routing_js', { callback: 'fos.Router.setData' }) }}"></script> 
{% endblock %}

{% if bigBagDisp == 'block' %} 
	
		<div class="panel panel-default">
		  <!-- Default panel contents -->
		  <div class="panel-heading">Ваши покупки</div>
		    <table class="table goodsbasketfont m-cart-full">
				<tr>
					<th>{{ childrenGoods|length }}</th>
					<th>Товар</th>
					<th class="hide_col1">Размер</th>
					<th class="hide_col1">Цвет</th>
					<th class="hide_col1">Цена за ед</th>
					<th>Кол-во</th>
					<th class="hide_col2">Цена за все</th>
					<th></th>
				</tr>
				{% for childrenGood in childrenGoods %}
					{% set idtr = "idtr" ~ loop.index0 %}
					{% set idrow2 = "idrow2" ~ loop.index0 %}
					{% set idnidk = "idnidk" ~ loop.index0 %}
					{% set idrowk = "idrowk" ~ loop.index0 %}

				<tr id="{{ idtr }}" class="onerow">

					<td>
						<img class="show__img" src="{{ asset(sourcePath[loop.index0]) }}">
					</td>
					<td class="title">{{ childrenGood.title }}</td>
					<td class="hide_col1">
						{{ sizeTitle[loop.index0] }}
					</td>
					<td class="hide_col1">
						{{ colorTitle[loop.index0] }}
					</td>
					
					<td class="hide_col1" id="{{ idrow2 }}">{{ childrenGood.priceGoods.rub }}</td>
					
					<td id="{{ idnidk }}"><input type="number" min="1" max="99" size="3" name="numbergoods" value="{{ nid[loop.index0] }}" onchange="basketbigchange({{ childrenGood.priceGoods.rub }}, this.value, {{ loop.index0 }}, {{ childrenGoods|length }})"/></td>
					
					<td class="hide_col2" id="{{ idrowk }}">{{ priceone[loop.index0] }}</td>
					<td>
						<i id="fountainCheck" class="fountainG{{ childrenGood.id }}{{ sizearr[loop.index0] }}{{ colorarr[loop.index0]}}"  data-fountain>
							<i id="fountainG_1" class="fountainG"></i>
							<i id="fountainG_2" class="fountainG"></i>
							<i id="fountainG_3" class="fountainG"></i>
							<i id="fountainG_4" class="fountainG"></i>
							<i id="fountainG_5" class="fountainG"></i>
							<i id="fountainG_6" class="fountainG"></i>
							<i id="fountainG_7" class="fountainG"></i>
							<i id="fountainG_8" class="fountainG"></i>
						</i>
						<img id="good_click_id" class="del_click" src="{{ asset('bundles/app/user/elements/delete_16x16.png')}}" onclick="goodbasketdel({{ childrenGood.id }}, {{ sizearr[loop.index0] }}, {{ colorarr[loop.index0] }}, 'true', 'ajax_checkout_user')">
					</td>
				</tr>		
				{% endfor %}
				<tr><td colspan= "8" id="priceall">К оплате: {{ priceall }}</td></tr>{#$prsite#}
				
			</table>
		</div>
	
{% else %}
	Корзина пустая 
	<script>
		route = Routing.generate('index_user');
		window.location.href = route;
	</script>
{% endif %}