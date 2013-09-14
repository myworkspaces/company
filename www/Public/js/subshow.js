<!--//--><![CDATA[//><!--
/*
舌签构造函数
SubShowClass(ID[,eventType][,defaultID][,openClassName][,closeClassName])
*/
function SubShowClass(ID,eventType,defaultID,openClassName,closeClassName){this.version="1.0";this.author="mengjia";this.parentObj=SubShowClass.$(ID);if(this.parentObj==null){throw new Error("SubShowClass(ID)参数错误:ID 对像存在!")};if(!SubShowClass.childs){SubShowClass.childs=[]};this.ID=SubShowClass.childs.length;SubShowClass.childs.push(this);this.lock=false;this.label=[];this.defaultID=defaultID==null?0:defaultID;this.selectedIndex=this.defaultID;this.openClassName=openClassName==null?"selected":openClassName;this.closeClassName=closeClassName==null?"":closeClassName;this.mouseIn=false;var mouseInFunc=Function("SubShowClass.childs["+this.ID+"].mouseIn = true"),mouseOutFunc=Function("SubShowClass.childs["+this.ID+"].mouseIn = false");if(this.parentObj.attachEvent){this.parentObj.attachEvent("onmouseover",mouseInFunc)}else{this.parentObj.addEventListener("mouseover",mouseInFunc,false)};if(this.parentObj.attachEvent){this.parentObj.attachEvent("onmouseout",mouseOutFunc)}else{this.parentObj.addEventListener("mouseout",mouseOutFunc,false)};if(typeof(eventType)!="string"){eventType="onmousedown"};eventType=eventType.toLowerCase();switch(eventType){case "onmouseover":this.eventType="mouseover";break;case "onmouseout":this.eventType="mouseout";break;case "onclick":this.eventType="click";break;case "onmouseup":this.eventType="mouseup";break;default:this.eventType="mousedown"};this.addLabel=function(labelID,contID,parentBg,springEvent,blurEvent){if(SubShowClass.$(labelID)==null){throw new Error("addLabel(labelID)参数错误:labelID 对像存在!")};var TempID=this.label.length;if(parentBg==""){parentBg=null};this.label.push([labelID,contID,parentBg,springEvent,blurEvent]);var tempFunc=Function('SubShowClass.childs['+this.ID+'].select('+TempID+')');if(SubShowClass.$(labelID).attachEvent){SubShowClass.$(labelID).attachEvent("on"+this.eventType,tempFunc)}else{SubShowClass.$(labelID).addEventListener(this.eventType,tempFunc,false)};if(TempID==this.defaultID){SubShowClass.$(labelID).className=this.openClassName;if(SubShowClass.$(contID)){SubShowClass.$(contID).style.display=""};if(parentBg!=null){this.parentObj.style.background=parentBg};if(springEvent!=null){eval(springEvent)}}else{SubShowClass.$(labelID).className=this.closeClassName;if(SubShowClass.$(contID)){SubShowClass.$(contID).style.display="none"}};if(SubShowClass.$(contID)){if(SubShowClass.$(contID).attachEvent){SubShowClass.$(contID).attachEvent("onmouseover",mouseInFunc)}else{SubShowClass.$(contID).addEventListener("mouseover",mouseInFunc,false)};if(SubShowClass.$(contID).attachEvent){SubShowClass.$(contID).attachEvent("onmouseout",mouseOutFunc)}else{SubShowClass.$(contID).addEventListener("mouseout",mouseOutFunc,false)}}};this.select=function(num,force){if(typeof(num)!="number"){throw new Error("select(num)参数错误:num 不是 number 类型!")};if(force!=true&&this.selectedIndex==num){return};var i;for(i=0;i<this.label.length;i++){if(i==num){SubShowClass.$(this.label[i][0]).className=this.openClassName;if(SubShowClass.$(this.label[i][1])){SubShowClass.$(this.label[i][1]).style.display=""};if(this.label[i][2]!=null){this.parentObj.style.background=this.label[i][2]};if(this.label[i][3]!=null){eval(this.label[i][3])}}else if(this.selectedIndex==i||force==true){SubShowClass.$(this.label[i][0]).className=this.closeClassName;if(SubShowClass.$(this.label[i][1])){SubShowClass.$(this.label[i][1]).style.display="none"};if(this.label[i][4]!=null){eval(this.label[i][4])}}};this.selectedIndex=num};this.random=function(){if(arguments.length!=this.label.length){throw new Error("random()参数错误:参数数量与标签数量不符!")};var sum=0,i;for(i=0;i<arguments.length;i++){sum+=arguments[i]};var randomNum=Math.random(),percent=0;for(i=0;i<arguments.length;i++){percent+=arguments[i]/sum;if(randomNum<percent){this.select(i);break}}};this.autoPlay=false;var autoPlayTimeObj=null;this.spaceTime=5000;this.play=function(spTime){if(typeof(spTime)=="number"){this.spaceTime=spTime};clearInterval(autoPlayTimeObj);autoPlayTimeObj=setInterval("SubShowClass.childs["+this.ID+"].nextLabel()",this.spaceTime);this.autoPlay=true};this.nextLabel=function(){if(this.autoPlay==false||this.mouseIn==true){return};var index=this.selectedIndex;index++;if(index>=this.label.length){index=0};this.select(index)};this.stop=function(){clearInterval(autoPlayTimeObj);this.autoPlay=false}};SubShowClass.$=function(objName){if(document.getElementById){return eval('document.getElementById("'+objName+'")')}else{return eval('document.all.'+objName)}}


function SetHome(obj, vrl) { 
    try {   
        obj.style.behavior = 'url(#default#homepage)';   
        obj.setHomePage(vrl);   
    } catch (e) {   
        if (window.netscape) {   
            try {   
                netscape.security.PrivilegeManager   
                        .enablePrivilege("UniversalXPConnect");   
            } catch (e) {   
                alert("此操作被浏览器拒绝！\n请在浏览器地址栏输入“about:config”并回车\n然后将 [signed.applets.codebase_principal_support]的值设置为'true',双击即可。");   
            }   
            var prefs = Components.classes['@mozilla.org/preferences-service;1']   
                    .getService(Components.interfaces.nsIPrefBranch);   
            prefs.setCharPref('browser.startup.homepage', vrl);   
        }   
    }   
}  