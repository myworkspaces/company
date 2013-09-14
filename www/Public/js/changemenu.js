<!--
//购物车
function divshou(obj)
{
	document.getElementById(obj).style.visibility="visible";
}
function hideshou(obj)
{
	document.getElementById(obj).style.visibility="hidden";
}

//title标题栏加入收藏 
function bookmark() {
	var title = document.title
	var url = document.location.href
	if (window.sidebar) window.sidebar.addPanel(title, url, "");
	else if (window.opera && window.print) {
		var mbm = document.createElement('a');
		mbm.setAttribute('rel', 'sidebar');
		mbm.setAttribute('href', url);
		mbm.setAttribute('title', title);
		mbm.click();
	}
	else if (document.all) window.external.AddFavorite(url, title);
} 


function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->

<!--
var loc=stringA=location.href.toLowerCase()
var strhref=""
var strlocation="/";
var len=strlocation.length;
var pos=stringA.indexOf(strlocation)

function lastfilename(stringA){

if (pos>=0){
	stringA=stringA.substring(pos+len,stringA.length);
	while (stringA.indexOf("/")>=0){
		pos=stringA.indexOf("/")
		stringA=stringA.substring(pos+1,stringA.length);
	}
}
return stringA
}	


function lastfoldername(stringA){
if (pos>=0){
	var pos1,pos2
	pos1 = stringA.lastIndexOf("/")
	stringA=stringA.substring(pos+len,pos1);
	pos2 = stringA.lastIndexOf("/")
	stringA=stringA.substring(pos2+1,pos1)
	}
return stringA
}

var lastfoldernames=lastfoldername(stringA)
//alert(lastfoldername);
//alert(lastfoldernames)
if(lastfoldernames=="headphones" || lastfoldernames=="products"  || lastfoldernames=="service"  || lastfoldernames=="news"  || lastfoldernames=="about"  )
{
	document.getElementById(lastfoldernames).style.background ="url(../../images/include/jt.gif) no-repeat bottom center";
	document.getElementById(lastfoldernames).style.color ="#EFE457";

}

//-->