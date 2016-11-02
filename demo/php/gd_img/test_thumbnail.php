<?php
/**
 *  生成指定尺寸下的缩略图
 *  version 0.2
 *  v0.2：修改图片的传入参数改为图片资源类型，增加了函数的复用性
 */
require '../common.php';
require DIR_SRC_PHP . '/gd_img/thumbnail.php';

$w = isset($_GET['w']) ? $_GET['w'] : 500;  //缩略图的宽
$h = isset($_GET['h']) ? $_GET['h'] : 500;  //缩略图的高
$r = isset($_GET['r']) ? $_GET['r'] : 36;   //缩略图的背景色r值
$g = isset($_GET['g']) ? $_GET['g'] : 36;   //缩略图的背景色g值
$b = isset($_GET['b']) ? $_GET['b'] : 36;   //缩略图的背景色b值
header("Content-type:image/jpg");
$rgb = array($r, $g, $b);
$img_path = DIR_RES_IMG . '/img1.1.jpg';
$img = imagecreatefromjpeg($img_path);

$thumb = thumbnail($img, $w, $h, $rgb);

imagejpeg($thumb);


