<?php
/**
 *  验证码生成程序
 *  version 0.1
 */
require '../common.php';
require DIR_SRC_PHP . '/gd_img/captcha.php';
$length = isset($_GET['l']) ? $_GET['l'] : 4;//验证码的字符个数
$disturb = isset($_GET['d']) ? $_GET['d'] : 1;//验证码的干扰背景类型
$size = isset($_GET['s']) ? $_GET['s'] : 35;//验证码的字体大小（同时影响验证码图片的大小）

$font_array = array(
    DIR_RES_TTF . '/t1.ttf',
    DIR_RES_TTF . '/t2.ttf',
    DIR_RES_TTF . '/t3.ttf',
    DIR_RES_TTF . '/t4.ttf',
    DIR_RES_TTF . '/t5.ttf',
    DIR_RES_TTF . '/t6.ttf',
    DIR_RES_TTF . '/t7.ttf',
    DIR_RES_TTF . '/t8.ttf',
    DIR_RES_TTF . '/t9.ttf',
    DIR_RES_TTF . '/t10.ttf'
);

//定义图片的http头，输出图片
header("Content-type:image/jpg");
$data = captcha($font_array, $length, $disturb, $size);
imagejpeg($data['img']);


