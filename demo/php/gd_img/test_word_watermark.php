<?php
/**
 *  为图片添加文件水印
 *  version 0.3
 *  v0.3:更改了方法的传入参数由图片路径改为图片资源对象，增加了图片的复用性
 */
require '../common.php';
require DIR_SRC_PHP . '/gd_img/word_watermark.php';

$pos = isset($_GET['pos']) ? $_GET['pos'] : 9;  //水印的预定义位置
$margin = isset($_GET['margin']) ? $_GET['margin'] : 5; //水印预定义位置的边距
$opt = isset($_GET['opt']) ? $_GET['opt'] : 50; //水印文字的透明度
$src_string = isset($_GET['s']) ? $_GET['s'] : 'watermark'; //水印文字的内容
$x = isset($_GET['x']) ? $_GET['x'] : 0;    //水印文字的自定义位置的x坐标
$y = isset($_GET['y']) ? $_GET['y'] : 0;    //水印文字的自定义位置的y坐标
$size = isset($_GET['size']) ? $_GET['size'] : 0;   //水印文字的大小
$r = isset($_GET['r']) ? $_GET['r'] : 0;    //水印颜色的r值
$g = isset($_GET['g']) ? $_GET['g'] : 0;    //水印颜色的g值
$b = isset($_GET['b']) ? $_GET['b'] : 0;    //水印颜色的b值
$angle = isset($_GET['a']) ? $_GET['a'] : 0;    //水印文字的倾斜角度

$dst_path = DIR_RES_IMG . '/img2.jpg';
$dst = imagecreatefromjpeg($dst_path);
$font_path = DIR_RES_TTF . '/msyhbd.ttc';

$dst = wordWatermark($src_string, $dst, $font_path, $opt, $size, $angle, array($r, $g, $b), $pos, $x, $y);

header("Content-type:image/jpg");
imagejpeg($dst);

