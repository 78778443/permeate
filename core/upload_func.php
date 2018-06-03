<?php
//文件上传九阳神功

function upload(&$info, $name, $dir = './uploads', $mimes = [], $exts = [], $size = 2000000)
{
    //初始化结果
    $mimes = empty($mimes) ? array('image/jpeg', 'image/png', 'image/gif', 'image/wbmp', 'text/plain') : $mimes;
    $exts = empty($exts) ? array('txt', 'jpeg', 'jpg', 'gif', 'png', 'bmp', 'GIF') : $exts;

    //1.观察数组
    $upload = $_FILES[$name];

    //2.判断是否是post上传
    if (!is_uploaded_file($upload['tmp_name'])) {
        $info = '非法上传！';
        return $info;
    }

    //3.判断是否上传错误
    if ($upload['error'] != 0) {
        switch ($upload['error']) {
            case 1:
                $info = '超出了php.ini当中的upload_file_size的值';
                return $info;
            case 2:
                $info = '超出了表单当中MX_FILE_SIZE的值';
                return $info;
            case 3:
                $info = '文件只有部分被上传';
                return $info;
            case 4:
                $info = '没有文件上传';
                return $info;
            case 6:
                $info = '找不到临时文件夹';
                return $info;
            case 7:
                $info = '文件写入失败';
                return $info;
        }
    }

    //4.判断文件mime类型
    if (!in_array($upload['type'], $mimes)) {
        $info = '文件的mime类型不被允许！';

        return $info;
    }

    //5.判断文件扩展名
    $ext = pathinfo($upload['name'], PATHINFO_EXTENSION);

    if (!in_array($ext, $exts)) {
        $info = '文件扩展名非法！';

        return $info;
    }

    //6.判断文件的大小

    if ($upload['size'] > $size) {
        $info = '对不起，亲，您的文件太大了呢！请重新选择一下！';
        return $info;
    }

    //7.新建目录，生成新的文件名称
    $dir = rtrim($dir, '/') . '/';
    $oldDir = $dir;
    $dir = $_SERVER['DOCUMENT_ROOT'] . $dir;
    if (!file_exists($dir)) {

        //新建目录
        //r 4 w 2 x 1     7 own 7 grp 7  other
        mkdir($dir, 0755, true);
    }

    $newname = uniqid() . '.' . $ext;

    //8.移动文件
    if (move_uploaded_file($upload['tmp_name'], rtrim($dir, '/') . '/' . $newname)) {
        $info = "亲爱的亲，您的文件意外的上传成功啦，这时多么美好的一件事情啊！";

        //9.保存信息
        $data = array(
            'oldname' => $_FILES['pic']['name'],
            'mime' => $_FILES['pic']['type'],
            'ext' => $ext,
            'size' => $_FILES['pic']['size'],
            'newname' => rtrim($dir, '/') . '/' . $newname
        );

        return $data;

    }
}