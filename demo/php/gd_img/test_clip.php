<?php
/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2016-10-30 21:03
 * @version:    0.0
 * @function:   功能说明
 */
require '../common.php';
require DIR_SRC_PHP . '/gd_img/clip_image.php';
$x = isset($_GET['x']) ? $_GET['x'] : 0;//裁剪的x坐标起点
$y = isset($_GET['y']) ? $_GET['y'] : 0;//裁剪的y坐标起点
$w = isset($_GET['w']) ? $_GET['w'] : 100;//裁剪的区域宽度
$h = isset($_GET['h']) ? $_GET['h'] : 100;//裁剪的区域高度
$s = isset($_GET['s']) ? $_GET['s'] : 1;//裁剪后的图片的缩放比例

$img = imagecreatefromjpeg(DIR_RES_IMG . '/img1.1.jpg');
$img = clipImage($img, $x, $y, $w, $h, $s);
header("Content-Type:image/jpeg");
imagejpeg($img);