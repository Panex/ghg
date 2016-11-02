<?php
/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2016-10-30 21:04
 * @version:    0.1
 * @description:   测试缩放图片尺寸的功能
 */
require '../common.php';
require DIR_SRC_PHP . '/gd_img/scale.php';
$scale_x = isset($_GET['x']) ? $_GET['x'] : 1;//x方向的缩放比例
$scale_y = isset($_GET['y']) ? $_GET['y'] : 0;//y反向的缩放比例

$img = imagecreatefromjpeg(DIR_RES_IMG . '/img1.1.jpg');
$img = scaleImage($img, $scale_x, $scale_y);
header("Content-Type:image/jpeg");
imagejpeg($img);