<?php
/**
 * SQLite数据库操作函数
 * 替代原有的mysql_func函数，保持接口兼容
 */

// 全局数据库连接
$GLOBALS['db_connection'] = null;

/**
 * 获取数据库连接
 */
function getDbConnection() {
    if ($GLOBALS['db_connection'] !== null) {
        return $GLOBALS['db_connection'];
    }

    try {
        // 确保数据目录存在
        $dbDir = dirname(DB_PATH);
        if (!is_dir($dbDir)) {
            mkdir($dbDir, 0777, true);
        }

        // 连接SQLite数据库
        $GLOBALS['db_connection'] = new PDO('sqlite:' . DB_PATH);
        $GLOBALS['db_connection']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $GLOBALS['db_connection']->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $GLOBALS['db_connection']->exec('PRAGMA encoding = "UTF-8"');
        $GLOBALS['db_connection']->exec('PRAGMA foreign_keys = ON');

        return $GLOBALS['db_connection'];
    } catch (PDOException $e) {
        die('数据库连接失败: ' . $e->getMessage());
    }
}

/**
 * 执行SQL查询（兼容原有mysql_func接口）
 * @param string $sql SQL语句
 * @return mixed 查询结果
 */
function mysql_func($sql) {
    try {
        $db = getDbConnection();

        // 获取SQL操作类型
        $sql = trim($sql);
        $firstWord = strtoupper(strtok($sql, " \t\n\r"));

        switch ($firstWord) {
            case 'SELECT':
            case 'SHOW':
            case 'PRAGMA':
                $stmt = $db->query($sql);
                if ($stmt === false) {
                    return false;
                }
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result ?: [];

            case 'INSERT':
                $result = $db->exec($sql);
                if ($result !== false) {
                    return $db->lastInsertId();
                }
                return false;

            case 'UPDATE':
            case 'DELETE':
                $result = $db->exec($sql);
                if ($result !== false) {
                    return $result; // 返回影响的行数
                }
                return false;

            case 'CREATE':
            case 'ALTER':
            case 'DROP':
            case 'INDEX':
                $result = $db->exec($sql);
                return $result !== false ? true : false;

            default:
                $result = $db->exec($sql);
                return $result !== false ? true : false;
        }
    } catch (PDOException $e) {
        // 返回false表示执行失败
        return false;
    }
}

/**
 * 转义字符串（兼容原有接口）
 * @param string $str 要转义的字符串
 * @return string 转义后的字符串
 */
function mysql_escape($str) {
    return str_replace("'", "''", $str);
}

/**
 * 关闭数据库连接
 */
function mysql_close_connection() {
    $GLOBALS['db_connection'] = null;
}
?>
