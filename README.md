## 0x00 前言

使用中遇到任何问题请在QQ群中进行反馈，我将倾力相助，QQ群号码见下方

## 一、轻松渗透测试系统

轻松渗透测试系统是我刚学PHP的时候开发的一个基于lamp环境的web应用。
    
代码很简单，开发初衷主要是学习PHP，现在发现当初写的这个程序好多漏洞，想了想可以用这个系统来训练挖掘漏洞能力。

现在开源出来，遵从MIT许可协议。如果大家有什么建议和想法，欢迎和我一起完善。

## 二、用途：
目前我主要用于WEB安全演示教学,也用来自己练习挖掘漏洞
目前发下包含了以下漏洞:
包含sql注入、XSS跨站、CSRF、本地包含等常见的web漏洞
包含密码找回、验证码等逻辑型漏洞
包含git/备份之类文件泄漏
包含图片附件类目录php执行权限
包含webShell上传漏洞

## 三、推荐安装:

很多人在安装环境出现问题，因此我提供了两种安装方式，docker安装和传统安装，最简单的是用docker安装，具体安装方法如下

### 3.1 Docker安装

permeate支持采用docker安装，这样安装起来更加简洁，安装教程文档如下

https://segmentfault.com/a/1190000017151621
    


### 3.2 传统安装：

项目在lamp环境下开发,建议在WampServer下安装,安装主要有两个要点，首先是添加一个虚拟主机，然后修改hosts文件


#### 增加虚拟主机
首先来看增加虚拟主机的方法，假设安装路径为: E:\www\permeate，在`httpd.conf`的最后位置添加

```
<VirtualHost *:80>
DocumentRoot "E:\www\permeate"
ServerName permeate.localhost
    <Directory "E:\www\permeate">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

在修改并保存之后，还需要重启WampServer，让配置文件生效。


#### 修改hosts文件
新增虚拟主机之后，现在需要修改hosts文件，windows系统hosts位置是 `C:\Windows\System32\drivers\etc\hosts` 

```
127.0.0.1 permeate.localhost
```


#### 开始安装
permeate系统提供在线安装功能，但很多人会报错，因此这里的安装方法是通过直接导入数据库，并修改配置文件的方式，导入数据库这里不做过讲解，主要提一下如何修改配置文件，配置文件位置是 `/conf/dbconf.php`
```
//数据库位置
!defined('DB_HOST') && define('DB_HOST', 'localhost');
//用户名
!defined('DB_USER') && define('DB_USER', 'root');
//密码
!defined('DB_PASS') && define('DB_PASS', 'root');
//数据库名称
!defined('DB_NAME') && define('DB_NAME', 'qingsong_bbs');
!defined('DB_CHARSET') && define('DB_CHARSET', 'utf8');
```
    
上面的配置文件在正常安装流程下不需要手动去编辑
    

    
        
###  3.3 运行效果

![sec](http://tuchuang.songboy.site/permeate/index.png?v=1)

### 四、后期维护：

考虑到目前的逻辑漏洞还不是太多，之后会继续添加更多功能，更新后会同步到GitHub，同时欢迎搭建加入qq群进行交流
![sec](http://tuchuang.songboy.site/permeate.jpg)

## Copyright

<table>
  <tr>
    <td>Weibo</td><td>汤清松</td>
  </tr>
  <tr>
    <td>QQ交流群</td><td>832677177</td>
  </tr>
  <tr>
    <td>Copyright</td><td>Copyright (c) 2017-2021 DaXia</td>
  </tr>
  <tr>
    <td>License</td><td>MIT License</td>
  </tr>
</table>
