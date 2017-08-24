function uploadtxt(id){
	//params = "?filetxt=" + filetxt + "&nocache1=" + Math.random() * 1000000;
	params = "?id=" + id + "&nocache1=" + Math.random() * 1000000;;
	request = new ajaxRequest();
	alert('rout');
	rout = Routing.generate('ajax_bag_user'); //, { id: 10, foo: "bar" }
	alert('rout');
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
					par = window.document.getElementById("content");
					//var parall;
					txtreply = this.responseText;
					alert('txtreply');
					/*myreply = JSON.parse(txtreply);			
					dstrex = myresize(myreply, "add");
					for(i = 0; i < dstrex.length; i++){		
						mydiv = document.createElement("div");
						mydiv.className = "divimg";
						myimg = document.createElement("img");
						myimg.src =  "./imagesw/" + myreply[i][0];
						mydiv.style.width = dstrex[i].toString() + "px";
						mydiv.appendChild(myimg);
						wx = Math.floor((dstrex[i] - myreply[i][1])/2);
						myimg.style.left = wx.toString() + "px";
						mydiv.style.margin = "5px";
						par.appendChild(mydiv);
					}
					this.abort(null)*/
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
}