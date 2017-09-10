/*$(document).ready(function(){
//function goodbasketcheck(id){
	$('.good_click').click(function(){
		goodid = $(this).attr('good-id');
		mclon = $(this).attr('mclon');
		rout = Routing.generate('ajax_bag_user', { id: goodid, mclon: mclon}); //,  mclon: mclon
		alert(rout);
		$.ajax({ 
			  url: rout,
			  success: function(data) {
			    $('.bascetsmall').html(data);
			  }
			});
	})
//}
})*/

//showGood.html.twig
function goodbasketcheck(id, mclon, route_name){
	var route = Router.route(route_name, { id: id, size: color_true, color: image_true, mclon: mclon});
	console.log(route) ;
	
  	$("i[data-fountain]").css("display", "block");
  	$("#fountainSmall").css("display", "block");
  	$("#fountainIncart").css("display", "block");

 // убрать коммент когда отлажу
  	$.ajax({ 
	  url: route,
	  success: function(data) {
	    $('.bascetsmall').html(data);
	  	$("#fountainIncart").css("display", "none");
	  }
	});
	// $(location).attr('href', route);
}

//bigBag.html.twig
function goodbasketdel(id, color_del, image_del, mclon, route_name){
	var route = Router.route(route_name, { id: id, size: color_del, color: image_del, mclon: mclon});
	console.log(route) ;
	
	$('.fountainG' + id + color_del + image_del).css("display", "block");
	$('.fountainCheck' + id + color_del + image_del).css("display", "block");
	
	$.ajax({ 
		  url: route,
		  success: function(data) {
		    $('.bascetsmall').html(data);
		  }
		});
	// $(location).attr('href', route);
}

//showGood.html.twig
function goodbuycheck(id, mclon, route_name){
	var route = Router.route(route_name, { id: id, size: color_true, color: image_true, mclon: mclon});
	
	//var route = Routing.generate(route_name, { id: id, size: color_true, color: image_true, mclon: mclon}); //,  mclon: mclon
	//alert('color_true: ' + color_true + ' image_true: ' + image_true + ' title_size: ' + title_size + ' title_color: ' + title_color);
	//alert(route);
	$('.bubblingG').css("display", "block");
	//alert(route);
	$.ajax({ 
		  url: route,
		  success: function(data) {
		    var route = Router.route('bag_register_secure');
		    // console.log('bag_register_secure: '+route) ;
		    $(location).attr('href', route);
		  }
		});
}

//checkoutBag.html.twig это изменение кол-ва в корзине при регистрации 
function basketbigchange(row2, nidk, k, itemnumber){
	
	priceall = 0;
	price = new Array();
	nid = new Array();
	//nid[k] = nidk;
	//document.getElementById("divid").innerHTML = "ni0= " + nid[0] + " ni1= " + nid[1] + "  pri0= " + pri[0] + " pri1= " + pri[1];
	row2 = row2 * nidk; //стоимость текущего товара на кол-во
	idnidk = "idnidk" + k;

	idrowk = "idrowk" + k;//стоимость текущего товара на кол-во
	document.getElementById(idrowk).innerHTML = row2;
	
	for(i=0; i < itemnumber; i++){
		idrowk = "idrowk" + i;
		idrow2 = "idrow2" + i;
		//div = document.getElementById(idrowk);
		//text = div.firstChild;
		price[i] = Number(document.getElementById(idrow2).firstChild.data);
		nid[i] = Number(document.getElementById(idnidk).firstChild.data);
		priceall = priceall + Number(document.getElementById(idrowk).firstChild.data);
		//document.getElementById("divid").innerHTML = text.data;
	}
	document.getElementById("priceall").innerHTML = "К оплате всего: " + priceall;

	var route = Router.route('basket_big_change', { kg2: k, nidaj: nidk });
	//var route = Routing.generate('basket_big_change', { kg2: k, nidaj: nidk }); //,  mclon: mclon
	
	nid1 = 4;

	//query = "basketbigclear.php?kg2=" + k + "&nidaj=" + nidk + "&nocache2=" + Math.random() * 1000000;

	$.ajax({ 
		  url: route,
		  success: function(data) {
		    //$('.bascetsmall').html(data);
		    //bag_register
		    //var route = Routing.generate('bag_register');
		    //$(location).attr('href',route);
		  }
		});

	/*if(document.request2 == undefined) request2 = new ajaxRequest2;

	request2.open("GET", query, true);

	request2.onreadystatechange = function()
	{
		if (this.readyState == 4)
		{
			if (this.status == 200)
			{
				if (this.responseText != null)
				{
					//document.getElementById("idback").innerHTML = this.responseText
				}
				else alert("Ajax error: No data received")
			}
			else alert( "Ajax error: " + this.statusText)
		}
		this.function = null;
	}
	
	request2.send(null)
}*/

/*function sizeSelect(f) {
      n = f.selectedIndex;
      //alert(n);
       alert("Выбран размер: " + f.options[n].value);
    }*/

/*function uploadtxt(id){
	//params = "?filetxt=" + filetxt + "&nocache1=" + Math.random() * 1000000;
	params = "?id=" + id + "&nocache1=" + Math.random() * 1000000;
	request = new ajaxRequest();
	//console.log(Routing.generate('index_user'));
	rout = Routing.generate('ajax_bag_user', { id: id}); //, { id: 10, foo: "bar" }
	//rout = "http://clothes_blog2.home/web/app_dev.php/user/ajax_bag_user";
	//alert(rout);
	request.open("GET", rout, true);//"uploadajx.php"
	request.onreadystatechange = function()
	{
		if (this.readyState == 4)
		{
			if (this.status == 200)
			{
				if (this.responseText != null)
				{
					//window.parent.document.getElementById("myajax").style.display="none";
					//var dstrex = new Array();
					par = document.getElementById('bascetsmall');//window.document.getElementById("content");
					//var parall;
					txtreply = this.responseText;
					//alert(txtreply);
					par.innerHTML = txtreply;
				}
				else alert("Ajax error: No data received")
			}
			else{
				uploadtxt()
			} 
		}
	}
	request.send();

	function ajaxRequest()
	{
		try
		{
			var request = new XMLHttpRequest()
		}
		catch(e1)
		{
			try
			{
				request = new ActiveXObject("Msxml2.XMLHTTP")
			}
			catch(e2)
			{
				try
				{
					request = new ActiveXObject("Microsoft.XMLHTTP")
				}
				catch(e3)
				{
					request = false
				}
			}
		}
		return request
	}*/
}