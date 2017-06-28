var isIe=(document.all)?true:false;
//设置select的可见状态
function setSelectState(state)
{
var objl=document.getElementsByTagName('select');
for(var i=0;i<objl.length;i++)
{
objl[i].style.visibility=state;
}
}
function mousePosition(ev)
{
if(ev.pageX || ev.pageY)
{
return {x:ev.pageX, y:ev.pageY};
}
return {
x:ev.clientX + document.body.scrollLeft - document.body.clientLeft,y:ev.clientY + document.body.scrollTop - document.body.clientTop
};
}
//弹出方法
function showMessageBox(wTitle,content,pos,wWidth)
{
closeWindow();
var bWidth=parseInt(document.documentElement.scrollWidth);
var bHeight=parseInt(document.documentElement.scrollHeight);
if(isIe){
setSelectState('hidden');}
var back=document.createElement("div");
back.id="back";
var styleStr="top:0px;left:0px;position:absolute;background:#666;width:"+bWidth+"px;height:"+bHeight+"px;";
styleStr+=(isIe)?"filter:alpha(opacity=0);":"opacity:0;";
back.style.cssText=styleStr;
document.body.appendChild(back);
showBackground(back,50);
var mesW=document.createElement("div");
mesW.id="mesWindow";
mesW.className="mesWindow";
mesW.innerHTML="<div class='mesWindowTop'><table width='100%' height='100%'><tr><td>"+wTitle+"</td><td style='width:1px;'><input type='button' onclick='closeWindow();' title='关闭窗口' class='close' value='关闭' /></td></tr></table></div><div class='mesWindowContent' id='mesWindowContent'>"+content+"</div><div class='mesWindowBottom'></div>";
styleStr="left:"+(((pos.x-wWidth)>0)?(pos.x-wWidth):pos.x)+"px;top:"+(pos.y)+"px;position:absolute;width:"+wWidth+"px;";
mesW.style.cssText=styleStr;
document.body.appendChild(mesW);
}
//让背景渐渐变暗
function showBackground(obj,endInt)
{
if(isIe)
{
obj.filters.alpha.opacity+=1;
if(obj.filters.alpha.opacity<endInt)
{
setTimeout(function(){showBackground(obj,endInt)},5);
}
}else{
var al=parseFloat(obj.style.opacity);al+=0.01;
obj.style.opacity=al;
if(al<(endInt/100))
{setTimeout(function(){showBackground(obj,endInt)},5);}
}
}
//关闭窗口
function closeWindow()
{
if(document.getElementById('back')!=null)
{
document.getElementById('back').parentNode.removeChild(document.getElementById('back'));
}
if(document.getElementById('mesWindow')!=null)
{
document.getElementById('mesWindow').parentNode.removeChild(document.getElementById('mesWindow'));
}
if(isIe){
setSelectState('');}
}
//测试弹出
function testMessageBox(ev)
{
var objPos = mousePosition(ev);
messContent="<from action='login.php' method='post' enctype='multipart/from-data'><div style='padding:20px 0 20px 0;text-align:center'><ul><li style='display:block; line-height:35px; border-bottom:1px dashed #ccc'>用户名:<input type='text' name='username' /><a href='registre1.php' style='color:#336699'>立即注册</a></li><li style='display:block; line-height:35px; border-bottom:1px dashed #ccc'>密&nbsp;&nbsp;码:<input type='password' name='password'/><a href='' style='color:#336699'>找回密码</a></li><li style='line-height:35px; padding-right:50px; border-bottom:1px dashed #ccc'>安全提问<select><option>安全提问(未设置请忽略)</option><option>母亲名字</option><option>父亲名字</option><option>父亲出生的城市</option></select></li><li style='padding-right:100px;display:block; line-height:35px;'><label style='cursor:pointer'><input type='checkbox' />自动登录</label></li><li style='padding-right:120px'><input type='image' src='./images/39.png' /></li></ul></div></from>";
showMessageBox('<font color="#336699">用户登录</font>',messContent,objPos,500);
}