		var tempUrl="http://www.monstercable.com.cn";
	
		var menuids=["treemenu1"] 
		function buildsubmenus_horizontal(){
			for (var i=0; i<menuids.length; i++){
				var ultags=document.getElementById(menuids[i]).getElementsByTagName("ul")
				for (var t=0; t<ultags.length; t++){
				
					if (ultags[t].parentNode.parentNode.id==menuids[i]){
					ultags[t].style.top=ultags[t].parentNode.offsetHeight+"px"
					//ultags[t].parentNode.getElementsByTagName("a")[0].className="mainfoldericon"
					}
					else{
					ultags[t].style.left=ultags[t-1].getElementsByTagName("a")[0].offsetWidth+"px"
					ultags[t].parentNode.getElementsByTagName("a")[0].className="subfoldericon"
					}
				
					ultags[t].parentNode.onmouseover=function(){
					this.getElementsByTagName("ul")[0].style.display="block"
					}
				
					ultags[t].parentNode.onmouseout=function(){
					this.getElementsByTagName("ul")[0].style.display="none"
					}
				}
			}
		}
		if (window.addEventListener)
			window.addEventListener("load", buildsubmenus_horizontal, false)
		else if (window.attachEvent)
			window.attachEvent("onload", buildsubmenus_horizontal)
/*导航当前显示*/		
	 function dh(on1)
		{
			document.getElementById(on1).style.color="#DF233C"
			document.getElementById(on1).style.fontWeight="bold"
			document.getElementById(on1).style.background ="url("+tempUrl+"/images/include/menubj_on.jpg) no-repeat";
		}
	