<?php
/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2016-10-30 10:30
 * @version:    0.3
 * @description:   将一张图片作为水印插入到另一张图片中，除了9个预定义位置外，还可以自定义水印位置与缩放水印图片
 */

/**
 * 将一张图片作为水印添加至另一张图片
 * @param  resource $src 水印图片的资源对象
 * @param  resource $dst 目标图片的资源对象
 * @param  integer $pos 水印的位置；1-9分别对应图片的九宫格位置（左上-右下）
 * @param  integer $margin 水印在边缘时与目标图片的间距，默认0
 * @param  integer $opt 水印图片的透明度，默认50([0-100])
 * @param  float $scale 水印图片的缩放大小
 * @param  float $pos_x 自定义水印图片的x坐标
 * @param  float $pos_y 自定义水印图片的y坐标
 * @return mixed  如果水印添加成功则返回添加水印后的目标图片对象，否则返回false
 */
function imageWatermark($src, $dst, $pos = 9, $margin = 0, $opt = 50, $scale = 0.5, $pos_x = 0.0, $pos_y = 0.0)
{
    //处理非法参数输入
    $margin = $margin <= 0 ? 0 : (float)$margin;
    $pos = ($pos <= 9 && $pos >= 1) ? $pos : 0;
    $opt = ($opt <= 100 && $opt >= 0) ? $opt : 50;

    //获取水印图片的长宽
    $src_width = imagesx($src);
    $src_height = imagesy($src);

    //获取目标图片的长宽
    $dst_width = imagesx($dst);
    $dst_height = imagesy($dst);

    /** 缩放水印图片 **/
    //计算缩放后的宽度
    $src_scale_width = $src_width * $scale;
    //计算缩放后的高度
    $src_scale_height = $src_height * $scale;
    //定义缩放后的画布
    $src_scale = imagecreatetruecolor($src_scale_width, $src_scale_height);
    //将原始水印($src)缩放后存放至($src_scale)
    if (!imagecopyresampled($src_scale, $src, 0, 0, 0, 0, $src_scale_width, $src_scale_height, $src_width, $src_height)) {
        return false;   //异常中断
    }

    //缩放后的水印图片合并的区域起始位置为(0,0)，即将水印图片完全复制到目标图片
    $src_scale_x = 0;
    $src_scale_y = 0;

    //水印图片合并的区域结束位置为水印的长宽，即全部输出水印图片
    $src_w = $src_scale_width;
    $src_h = $src_scale_height;

    //定义水印的6个坐标，互相组合成9个（x,y）坐标
    $left_x = $margin;  //左边的水印的横坐标
    $center_x = ($dst_width - $src_scale_width) / 2;    //横向中间的水印的横坐标
    $right_x = $dst_width - $src_scale_width - $margin; //右边的水印的横坐标

    $top_y = $margin;   //上方水印的纵坐标
    $center_y = ($dst_height - $src_scale_height) / 2;  //纵向中间水印的纵坐标
    $bottom_y = $dst_height - $src_scale_height - $margin;  //下方水印的纵坐标

    //根据传入的pos参数，决定水印的位置，即定义dst_x,dst_y即可，并且加上margin的偏移量
    switch ($pos) {
        case 1:  //左上
            $dst_x = $left_x;
            $dst_y = $top_y;
            break;
        case 2:   //上
            $dst_x = $center_x;
            $dst_y = $top_y;
            break;
        case 3:   //右上
            $dst_x = $right_x;
            $dst_y = $top_y;
            break;
        case 4:   //左
            $dst_x = $left_x;
            $dst_y = $center_y;
            break;
        case 5:   //中
            $dst_x = $center_x;
            $dst_y = $center_y;
            break;
        case 6:   //右
            $dst_x = $right_x;
            $dst_y = $center_y;
            break;
        case 7:   //左下
            $dst_x = $left_x;
            $dst_y = $bottom_y;
            break;
        case 8:   //下
            $dst_x = $center_x;
            $dst_y = $bottom_y;
            break;
        case 9:   //右下
            $dst_x = $right_x;
            $dst_y = $bottom_y;
            break;
        default:
            $dst_x = (float)$pos_x;//强制转换输入参数以消除异常输入
            $dst_y = (float)$pos_y;//强制转换输入参数以消除异常输入
            break;
    }

    //将水印合并至原图片。
    //原理为将原图片的(src_x,src_y)起点至（src_w,src_h)区域的内容复制到目标图片的（dst_x,dst_y）为起始点的位置，并给原图片设置opt的透明度
    if (imagecopymerge($dst, $src_scale, $dst_x, $dst_y, $src_scale_x, $src_scale_y, $src_w, $src_h, $opt)) {
        //返回合并后的目标图片的资源对象
        return $dst;
    }
    else {
        return false;
    }

}
