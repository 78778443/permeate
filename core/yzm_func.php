<?php
session_start();//开启session
function yzm($width = 200, $height = 60, $type = 1, $length = 4)
{

    //1.创建画布
    $img = imagecreatetruecolor($width, $height);

    //2.分配颜色
    function scolor($img)
    {
        return imagecolorallocate($img, mt_rand(0, 120), mt_rand(0, 120), mt_rand(0, 120));
    }

    function qcolor($img)
    {
        return imagecolorallocate($img, mt_rand(120, 255), mt_rand(120, 255), mt_rand(120, 255));
    }

    $qcolor = qcolor($img);
    $scolor = scolor($img);

    //3.操作图形
    //a.先把画布填充
    imagefilledrectangle($img, 0, 0, $width, $height, $qcolor);

    //b.生成随机的字符串
    switch ($type) {
        case 0:
            $str = implode("", array_rand(range(0, 9), $length));//array(0=>0,1,2,3,...9=>9)
            break;
        case 1:
            $str = join("", array_rand(array_flip(range('a', 'z')), $length));//array(0=>'a'.....25=>'z')
            break;
        case 2:
        default:
            $str = join("", array_rand(array_merge(range(0, 9), array_flip(range('a', 'z')), array_flip(range('A', 'Z'))), $length));
            break;
    }
    //session的写入直接去给$_SESSION赋值
    $_SESSION['yzm'] = $str;
    //c.写字符串
    for ($i = 0; $i < $length; $i++) {
        imagettftext($img, $width / 5, mt_rand(-5, 5), 15 + $i * ($width / $length), mt_rand($height - 5, $height + 5) - 15, $scolor, __DIR__ . '/../static/font/arial.ttf', $str[$i]);
    }

    //d.加干扰素
    for ($i = 0; $i < 200; $i++) {
        imagesetpixel($img, mt_rand(0, $width), mt_rand(0, $height), $scolor);
    }
    for ($i = 0; $i < 5; $i++) {
//        imageline($img, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), $scolor);
    }

    //4.定义header头
    header("content-type:image/png");

    //5.输出图像
    imagepng($img);

    //6.销毁资源
    imagedestroy($img);

}

yzm();