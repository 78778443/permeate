## 轻松渗透测试系统

   轻松渗透测试系统是我刚学PHP的时候开发的一个基于lamp环境的web应用。
    
    代码很简单，开发初衷主要是学习PHP，现在发现当初写的这个程序好多漏洞，想了想可以用这个系统来训练挖掘漏洞能力。
    
    现在开源出来，遵从MIT许可协议。如果大家有什么建议和想法，欢迎和我一起完善。

### 用途：
    目前我主要用于WEB安全演示教学,也用来自己练习挖掘漏洞
    目前发下包含了以下漏洞:
	包含sql注入、XSS跨站、CSRF、本地包含等常见的web漏洞
	包含密码找回、验证码等逻辑型漏洞
	包含git/备份之类文件泄漏
	包含图片附件类目录php执行权限
	包含webshell上传漏洞

### 推荐安装:

    项目在lamp环境下开发,建议在wampserver下安装


### 使用说明：

    假设安装路径为: E:\www\permeate
    
    下载代码到目录,删除文件 /install/install.lock
    
    在httpd.conf的最后位置添加
    <VirtualHost *:80>
    DocumentRoot "E:\www\permeate"
    ServerName permeate.localhost
    	<Directory "E:\www\permeate">
            Options Indexes FollowSymLinks
            AllowOverride All
    		Require all granted
        </Directory>
    </VirtualHost>
    
    绝对路径如有变动，需对应修改
    修改文件: C:\Windows\System32\drivers\etc\hosts
    加入 127.0.0.1 permeate.localhost
    然后重启wampserver
    访问permeate.localhost/install/  进入界面安装
    


### 配置文件详细说明：

    RulePath = "/conf/dbconf.php"

    //数据库位置
    !defined('DB_HOST') && define('DB_HOST', 'localhost');
    //用户名
    !defined('DB_USER') && define('DB_USER', 'root');
    //密码
    !defined('DB_PASS') && define('DB_PASS', 'root');
    //数据库名称
    !defined('DB_NAME') && define('DB_NAME', 'qingsong_bbs');
    !defined('DB_CHARSET') && define('DB_CHARSET', 'utf8');
    
    上面的配置文件在正常安装流程下不需要手动去编辑
        
###效果图如下：

![sec](http://tuchuang.songboy.net/permeate/index.png)

### 代码更新：

    考虑到目前的逻辑漏洞还不是太多，之后会继续添加更多功能，更新后会同步到GitHub

## Copyright

<table>
  <tr>
    <td>Weibo</td><td>汤清松</td>
  </tr>
  <tr>
    <td>QQ交流群</td><td>374254526</td>
  </tr>
  <tr>
    <td>Copyright</td><td>Copyright (c) 2017- daxia</td>
  </tr>
  <tr>
    <td>License</td><td>MIT License</td>
  </tr>
</table>
