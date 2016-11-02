<?php
/**
 *  从一张图片中裁剪出制定比例的区域，并将之缩放到制定尺寸
 *  version 0.2
 *  v0.2：更改了方法的传入参数由图片路径改为图片资源对象，增加了图片的复用性
 */

require '../common.php';
require DIR_SRC_PHP . '/gd_img/cutnail.php';

$pos = isset($_GET['pos']) ? $_GET['pos'] : 0;//截取时的起始位置
$w = isset($_GET['w']) ? $_GET['w'] : 500;//截取的宽
$h = isset($_GET['h']) ? $_GET['h'] : 500;//截取的高

header("Content-type:image/jpg");
$img_path = DIR_RES_IMG . '/img1.1.jpg';
$img = imagecreatefromjpeg($img_path);
$cut = cutnail($img, $w, $h, $pos);
imagejpeg($cut);


