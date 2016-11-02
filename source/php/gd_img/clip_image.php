<?php
/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2016-10-30 20:11
 * @version:    0.1
 * @function:   从一张图片中截取一部分，并将之等比例缩放后返回
 */

/**
 * @param resource $img 图片对象
 * @param float $x 截图横坐标起始点
 * @param float $y 截图纵坐标起始点
 * @param float $width 截图长度
 * @param float $height 截图高度
 * @param int $scale 截图后的缩放比例，默认为1，即不缩放
 * @return bool|resource 若截图成功，则返回截图后的对象，否则返回false
 */
function clipImage($img, $x, $y, $width, $height, $scale = 1)
{
    /** 判断参数合法性 */
    //获取图片的长宽
    $img_width = imagesx($img);
    $img_height = imagesy($img);
    //截图的起始坐标应该位于[0,$img_width或$img_height]之间，否则坐标置为0
    $x = ($x >= 0 && $x <= $img_width) ? (float)$x : 0;
    $y = ($y >= 0 && $y <= $img_height) ? (float)$y : 0;
    //截图的长度应该位于[0,$img_width或$img_height]之间，否则，先将截图的尺寸置为图片的尺寸
    $width = ($width <= $img_width && $width > 0) ? (float)$width : $img_width;
    $height = ($height <= $img_height && $height > 0) ? (float)$height : $img_height;
    //坐标+截图尺寸因在(0,$img_width或$img_height]之间，否则，截图至末尾
    $width = ($x + $width) <= $img_width ? $width : ($img_width - $x);
    $height = ($y + $height) <= $img_height ? $height : ($img_height - $y);

    $scale_width = $width * $scale;
    $scale_height = $height * $scale;
    //定义截图后的图片载体对象
    $clip = imagecreatetruecolor($scale_width, $scale_height);

    if (imagecopyresampled($clip, $img, 0, 0, $x, $y, $scale_width, $scale_height, $width, $height)) {
        return $clip;
    }
    else {
        return false;
    }
}

