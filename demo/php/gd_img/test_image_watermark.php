<?php
/**
 *  为图片添加水印
 *  version 0.2
 *  v0.2：修改了图片的传入参数为图片资源对象，增加了函数的复用性
 */
require '../common.php';
require DIR_SRC_PHP . '/gd_img/image_watermark.php';

$pos = isset($_GET['pos']) ? $_GET['pos'] : 9;//预定义的水印位置
$margin = isset($_GET['margin']) ? $_GET['margin'] : 5;//预订义的水印位置与图片边框的间距
$opt = isset($_GET['opt']) ? $_GET['opt'] : 50;//水印图片的透明度
$scale = isset($_GET['sca']) ? $_GET['sca'] : 1;//水印图片的缩放比例
$pos_x = isset($_GET['x']) ? $_GET['x'] : 0;//自定义水印位置的x坐标，使用需要将$pos设置为0
$pos_y = isset($_GET['y']) ? $_GET['y'] : 0;//自定义水印位置的y坐标，使用需要将$pos设置为0

$src_path = DIR_RES_IMG . '/watermark.jpg';
$dst_path = DIR_RES_IMG . '/img3.jpg';

//根据输入的图片路径，得到图片的资源对象
$src = imagecreatefromjpeg($src_path);
$dst = imagecreatefromjpeg($dst_path);

$dst = imageWatermark($src, $dst, $pos, $margin, $opt, $scale, $pos_x, $pos_y);

header("Content-type:image/jpg");
imagejpeg($dst);

