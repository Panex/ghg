<?php
/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2016-10-30 9:45
 * @version:    0.2
 * @description:   生成指定大小的图片缩略图；原图片只会被缩放，不会被裁剪，因此缩略图可能会产生空白填充
 */

/**
 * 生成制定大小的图片缩略图
 * @param  resource $img 需要生成缩略图的图片资源对象
 * @param  integer $width 生成的缩略图的宽
 * @param  integer $height 生成的缩略图的高
 * @param  array $rgb 缩略图的背景填充色
 * @return mixed 如果图片生成成功，则返回生成的缩略图资源对象，否则返回false
 */
function thumbnail($img, $width = 200, $height = 200, $rgb = array(36, 36, 36))
{
    //如果宽高有一个参数不合法，则将宽高均设置为默认
    if (!($width > 0 && $height > 0)) {
        $width = 200;
        $height = 200;
    }
    else {
        $width = (float)$width;
        $height = (float)$height;
    }

    //如果颜色值有一个不合法，则将颜色设置为默认
    if (!($rgb[0] >= 0 && $rgb[0] <= 255 && $rgb[1] >= 0 && $rgb[1] <= 255 && $rgb[2] >= 0 && $rgb[2] <= 255)) {
        $rgb = array(36, 36, 36);
    }

    //创建指定大小的缩略图画布
    $thumb = imagecreatetruecolor($width, $height);

    //给缩略图定义背景色，并添加到背景上
    $thumb_bg = imagecolorallocate($thumb, $rgb[0], $rgb[1], $rgb[2]);
    imagefill($thumb, 0, 0, $thumb_bg);

    //获取原图片的长宽
    $img_width = imagesx($img);
    $img_height = imagesy($img);

    //计算原图片与缩略图的大小比例
    $img_per = $img_width / $img_height;
    $thumb_per = $width / $height;

    //根据原图片与缩略图的宽高比例之间的比较，计算原图片缩小后的大小
    if ($img_per > $thumb_per) { //如果图片比例大于缩略图比例
        //图片缩小后的宽度不变
        $new_width = $width;
        //高度需要缩小，根据new_width:new_height=img_width:img_height(图片等比例缩放后比例不变)，算出new_height
        $new_height = $new_width * $img_height / $img_width;
    }
    else { //如果图片比例小于缩略图比例
        //图片缩小后高度不变
        $new_height = $height;
        //宽度需要缩小，根据new_width:new_height=img_width:img_height(图片等比例缩放后比例不变)，算出new_width
        $new_width = $new_height * $img_width / $img_height;
    }

    $thumb_x = ($width - $new_width) / 2; //缩略图上放置原图片的起始点横坐标
    $thumb_y = ($height - $new_height) / 2;//缩略图上放置原图片的起始点纵坐标
    $img_x = 0;//原图片要拷贝至缩略图的区域的起始点横坐标
    $img_y = 0;//原图片要拷贝至缩略图区域的起始点纵坐标

    //将原图片（$img）的($img_x,$img_y)至($img_width,$img_height)的区域拷贝至缩略图($thumb)上的($thumb_x,$thumb_y)至($new_width,$new_height)区域内；拷贝过程中，原图片会被等比例缩放至缩略图内定义的区域的大小
    if (imagecopyresampled($thumb, $img, $thumb_x, $thumb_y, $img_x, $img_y, $new_width, $new_height, $img_width, $img_height)) {
        return $thumb;
    }
    else {
        return false;
    }
}