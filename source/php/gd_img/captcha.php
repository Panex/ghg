<?php
/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2016-10-30 9:33
 * @version:    0.3
 * @function:   可以任意生成的验证码长度
 *
 * 0.3：将字体文件改为用参数传入，提升了函数的可移植性
 */

/**
 * 返回一个随机的颜色
 * @param  resource $img 图片资源对象
 * @param  integer $deep 图片的颜色深浅度，[-4,4]，值越大颜色越深，0代表忽略深度值而随机取值
 * @return integer $color  颜色对象
 */
function randColor($img, $deep = 0)
{
    switch ($deep) {
        case -4:
            $r = mt_rand(224, 255);
            $g = mt_rand(224, 255);
            $b = mt_rand(224, 255);
            break;
        case -3:
            $r = mt_rand(192, 223);
            $g = mt_rand(192, 223);
            $b = mt_rand(192, 223);
            break;
        case -2:
            $r = mt_rand(160, 191);
            $g = mt_rand(160, 191);
            $b = mt_rand(160, 191);
            break;
        case -1:
            $r = mt_rand(128, 159);
            $g = mt_rand(128, 159);
            $b = mt_rand(128, 159);
            break;
        case 1:
            $r = mt_rand(96, 127);
            $g = mt_rand(96, 127);
            $b = mt_rand(96, 127);
            break;
        case 2:
            $r = mt_rand(64, 95);
            $g = mt_rand(64, 95);
            $b = mt_rand(64, 95);
            break;
        case 3:
            $r = mt_rand(32, 63);
            $g = mt_rand(32, 63);
            $b = mt_rand(32, 63);
            break;
        case 4:
            $r = mt_rand(0, 31);
            $g = mt_rand(0, 31);
            $b = mt_rand(0, 31);
            break;
        default:
            $r = mt_rand(0, 255);
            $g = mt_rand(0, 255);
            $b = mt_rand(0, 255);
    }
    return imagecolorallocate($img, $r, $g, $b);
}


/**
 * @param int $length 输出的字符长度，若小于0或不为数值型，则只返回一个字符，若为浮点数，则返回向下取整的字符数
 * @return string   返回指定长度的随机字符串
 */
function randString($length = 1)
{
    $length = $length < 1 ? 1 : $length;
    $str = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefhjkmnpqrstuvwxyz2345678";
    $str_len = strlen($str) - 1;
    $s = '';
    for ($i = 0; $i < $length; $i++) {
        $c = $str[mt_rand(0, $str_len)];
        $s .= $c;
    }
    return $s;
}


/**
 * @param  array $font_array 字体文件数组，其中第0个会用来生成干扰字符串，剩下的会作为验证码字符串
 * @param  integer $length 验证码长度
 * @param  integer $disturb 干扰背景的类型，1代表只使用文字干扰，2代表只使用线条干扰，其他代表同时使用两种干扰
 * @param  integer $size 验证码大小
 * @return mixed    返回一个数组，第一个元素为验证码的文本，第二个元素为验证码的图片对象
 */
function captcha($font_array, $length = 4, $disturb = 1, $size = 35)
{

    $size = $size > 0 ? (float)$size : 35;
    $length = $length > 0 ? (int)$length : 4;

    //创建画布
    $width = $size * 1.2 * $length;
    $height = $size + 20;
    $img = imagecreatetruecolor($width, $height);

    //校验参数
    $font_array_len = count($font_array);
    if ($font_array_len < 2) {  //若字体文件数过小，则返回false
        $data['code'] = '';
        $data['img'] = $img;
        return $data;
    }
    foreach ($font_array as $item) {    //若字体列表中有不存在的文件，则返回false
        if (!is_file($item)) {
            $data['code'] = '';
            $data['img'] = $img;
            return $data;
        }
    }

    //设置一个浅色作为背景色
    $bg_color = randColor($img, -4);
    //填充背景色
    imagefill($img, 0, 0, $bg_color);

    //生成干扰背景文字
    if ($disturb != 2) {    //只要传入的干扰参数不是2，就使用文字背景干扰
        for ($i = 0; $i < $length * 2; $i++) {
            $small_size = 12;
            $angle = mt_rand(-45, 45);
            $x = mt_rand(0, $width);
            $y = mt_rand(0, 50);
            $str_color = randColor($img, mt_rand(-4, -2));
            $ttf = $font_array[0];
            $b_str = randString(6);
            imagettftext($img, $small_size, $angle, $x, $y, $str_color, $ttf, $b_str);
        }
    }


    //生成随机的验证码
    $captcha = randString($length);


    //循环输出验证码
    for ($i = 0; $i < $length; $i++) {
        $font_size = $size + mt_rand(-3, 3);
        //定义一个小的随机验证码旋转角度
        $angle = mt_rand(-30, 30);
        //定义验证码起始位置坐标（横坐标），横坐标应该轻微地左右移动
        $x = $i * $size * 1.2 + mt_rand(-0.1 * $size, 0.2 * $size);
        //定义验证码基线坐标（纵坐标），它应该能够轻微地浮动
        $y = mt_rand($size - 5, $size + 20);
        //定义一个随机的深色为验证码颜色
        $char_color = randColor($img, mt_rand(2, 4));
        //定义随机的验证码字体
        $ttf = $font_array[mt_rand(1, $font_array_len - 1)];
        //生成验证码的一个字符
        imagettftext($img, $font_size, $angle, $x, $y, $char_color, $ttf, $captcha[$i]);
    }

    //在验证码上方画干扰线
    if ($disturb != 1) {    //只要传入的干扰参数不是1，就使用线条背景干扰
        for ($j = 0; $j < 3; $j++) {
            $line_color = randColor($img, 0);
            imageline($img, mt_rand(0, $width / 4), mt_rand(0, 50), mt_rand($width / 4 * 3, $width), mt_rand(0, 50), $line_color);
        }
    }

    //给背景添加黑色边框
    $border_color = imagecolorallocate($img, 0, 0, 0);
    //创建一个矩形
    imagerectangle($img, 0, 0, $width - 1, $height - 1, $border_color);

    $data['code'] = $captcha;
    $data['img'] = $img;
    return $data;
}