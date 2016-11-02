<?php
/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2016-10-30 10:03
 * @version:    0.3
 * @description:   将图片裁剪成给定长宽的比例后，再将裁剪后的图片缩放到该长宽（相当于填充）
 *                此方法会按照给定的比例，保留图片的最大部分
 */

/**
 * 将一张图片截取一定比例的区域，并缩放至指定大小
 * @param   resource $img 需要截取的图片的资源对象
 * @param   integer $width 截取后的图片高度
 * @param   integer $height 截取后的图片高度
 * @param   integer $pos 截取的位置，取值为0-4,分别代表从四角和中间截取
 * @return  mixed   如果截取成功，则返回截取后的图片对象，否则返回false
 */
function cutnail($img, $width = 200, $height = 200, $pos = 0)
{

    $pos = ($pos >= 0 && $pos <= 4) ? (int)$pos : 0;
    //创建缩略图画布
    $cut = imagecreatetruecolor($width, $height);

    //获取原图片的长宽
    $img_width = imagesx($img);
    $img_height = imagesy($img);

    //计算原图片与缩略图的大小比例
    $img_per = $img_width / $img_height;
    $cut_per = $width / $height;

    if ($img_per > $cut_per) {  //如果图片的比例高于截取图的比例，代表需要截取掉图片的宽，而高度保持不变
        $new_height = $img_height;
        //n_w:n_h = w:h
        $new_width = $new_height * $width / $height;

    }
    else {  //如果图片的比例低于截取图的比例，代表需要截取掉图片的高，则宽度保持不变
        $new_width = $img_width;
        //n_w:n_h = w:h
        $new_height = $height * $new_width / $width;

    }

    switch ($pos) {
        case 1: //截取左上部
            $img_x = 0;
            $img_y = 0;
            break;
        case 2: //截取右上部
            $img_x = $img_width - $new_width;
            $img_y = 0;
            break;
        case 3: //截取左下部
            $img_x = 0;
            $img_y = $img_height - $new_height;
            break;
        case 4: //截取右下
            $img_x = $img_width - $new_width;
            $img_y = $img_height - $new_height;
            break;
        case 0: //截取中间（默认）
        default:
            //图片截取的横坐标起始点为（原图片宽度-截取后的宽度）/2,纵坐标从0开始截取全部
            $img_x = ($img_width - $new_width) / 2;
            //图片截取的纵坐标起始点为（原图片长度-截取后的长度）/2，横坐标从0开始截取全部
            $img_y = ($img_height - $new_height) / 2;
            break;
    }

    $cut_x = 0; //缩略图上放置原图片的起始点横坐标
    $cut_y = 0;//缩略图上放置原图片的起始点纵坐标

    //将原图片（$img）的($img_x,$img_y)至($new_width,$new_height)的区域拷贝至缩略图($cut)上的($cut_x,$cut_y)至($width,$height)区域(填满cut)内；拷贝过程中，原图片会被等比例缩放至缩略图内定义的区域的大小
    if (imagecopyresampled($cut, $img, $cut_x, $cut_y, $img_x, $img_y, $width, $height, $new_width, $new_height)) {
        //返回截取后的图片资源对象
        return $cut;
    }
    else {
        return false;
    }
}