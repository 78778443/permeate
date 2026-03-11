<?php

class backup
{
    function __construct()
    {

    }

    /**
     * 数据库备份管理页面
     */
    public function index()
    {
        displayTpl('backup/index');
    }

    /**
     * 命令执行漏洞：备份功能存在命令注入
     * 漏洞利用：filename=test;cat /etc/passwd;
     * 或者：filename=test|whoami
     * 或者：filename=`id`
     */
    public function _do_backup()
    {
        // 获取备份文件名
        $filename = isset($_POST['filename']) ? $_POST['filename'] : 'backup_' . date('YmdHis');

        // 漏洞代码：直接将用户输入拼接到系统命令中
        $backup_dir = $_SERVER['DOCUMENT_ROOT'] . '/backup/';

        // 创建备份目录
        if (!is_dir($backup_dir)) {
            mkdir($backup_dir, 0777, true);
        }

        // 数据库配置
        $db_host = DB_HOST;
        $db_user = DB_USER;
        $db_pass = DB_PASS;
        $db_name = DB_NAME;

        // 漏洞代码：命令注入点
        // 用户可以通过filename参数注入任意命令
        $command = "mysqldump -h{$db_host} -u{$db_user} -p{$db_pass} {$db_name} > {$backup_dir}{$filename}.sql 2>&1";

        // 执行命令
        $output = array();
        $return_var = 0;
        exec($command, $output, $return_var);

        if ($return_var === 0) {
            echo "<script>alert('备份成功！文件保存在: {$filename}.sql');history.go(-1);</script>";
        } else {
            echo "<script>alert('备份失败！');history.go(-1);</script>";
        }

        // 显示命令输出（方便调试，也会泄露信息）
        if (!empty($output)) {
            echo "<pre>命令输出:\n";
            print_r($output);
            echo "</pre>";
        }
    }

    /**
     * 另一个命令执行漏洞点：ping功能
     * 漏洞利用：ip=127.0.0.1;cat /etc/passwd
     */
    public function ping()
    {
        displayTpl('backup/ping');
    }

    public function _do_ping()
    {
        $ip = isset($_POST['ip']) ? $_POST['ip'] : '';

        if (empty($ip)) {
            echo "<script>alert('请输入IP地址！');history.go(-1);</script>";
            exit;
        }

        // 漏洞代码：直接拼接用户输入到命令中
        // 可以通过 | ; & ` $() 等符号注入命令
        $command = "ping -c 4 " . $ip;

        echo "<div style='padding: 20px;'>";
        echo "<h4>执行命令: " . htmlspecialchars($command) . "</h4>";
        echo "<pre>";
        // 危险：直接输出命令执行结果
        system($command);
        echo "</pre>";
        echo "<a href='javascript:history.go(-1)'>返回</a>";
        echo "</div>";
    }
}
