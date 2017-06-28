function gspan(cobj){
			while(true){
				if(cobj.nextSibling.nodeName!="SPAN")
					cobj=cobj.nextSibling;
				else
					return cobj.nextSibling;
			}
		}
		function check(obj,info,fun){
			var sp=gspan(obj);
			obj.onfocus=function(){	
				sp.innerHTML=info;
				sp.className="stats2";
			}
			obj.onblur=function(){
				if(fun(this.value)){
					sp.innerHTML="输入正确";
					sp.className="stats4";
				}else{
					sp.innerHTML=info;
					sp.className="stats3";
				}
			}
		}
		onload=function(){//onload页面加载完验证
			var username=document.getElementsByName("user")[0];
			var password=document.getElementsByName("pass")[0];
			var repass=document.getElementsByName("repa")[0];
			var email=document.getElementsByName("email")[0];		
			//alert(username.nextSibling.nodeName);
		
		check(username,"用户名由3到15个字符组成",function(val){
		if(val.match(/^\S+$/) && val.length >=3 && val.length <=20)
			return true;
		else
			return false;
		});
		check(password,"请填写密码",function(val){
			if(val.match(/^\S+$/) && val.length >=1 &&  val.length <=20)
				return true;
			else
				return false;
		});
		check(repass,"确定密码要和上面一致",function(val){
			if(val.match(/^\S+$/) && val.length >=1 &&  val.length <=20 && val==password.value)
				return true;
			else
				return false;
		});
		check(email,"要按邮箱规则输入",function(val){
			if(val.match(/\w+@\w+\.\w/)){
				return true
			}else{
				return false
			}
		});
		}