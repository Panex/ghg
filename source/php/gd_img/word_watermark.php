<?php
/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2016-10-30 14:10
 * @version:    0.5
 * @function:   为图片添加文字水印，除了已经预定义的9个位置外，还可以自定义位置，自定义水印颜色
 *
 * 0.5：将字体文件改为参数传入，提升了程序的可移植性
 */

/**
 * 为图片添加文字水印
 * @param string $src_string 水印文字
 * @param resource $dst 目标图片资源对象
 * @param string $font_path 字体文件路径（相对于调用文件的路径或绝对路径）
 * @param int $opt 水印透明度（0-127）
 * @param int $size 水印文字大小
 * @param int $angle 水印文字旋转的角度
 * @param array $rgb 水印颜色，非法输入时使用默认颜色（255,255,255）
 * @param int $pos 水印默认位置1-9，其他值是自定义位置
 * @param int $pos_x 自定义水印位置x坐标
 * @param int $pos_y 自定义水印位置y坐标
 * @return mixed
 */
function wordWatermark($src_string, $dst, $font_path, $opt = 0, $size = 50, $angle = 0, $rgb = array(255, 255, 255), $pos = 1, $pos_x = 0, $pos_y = 0)
{
    //处理非法参数输入
    $margin = 10;
    $pos = ($pos <= 9 && $pos >= 1) ? $pos : 0;
    $opt = ($opt <= 127 && $opt >= 0) ? $opt : 0;
    $size = $size > 0 ? (float)$size : 50;
    $angle = (float)$angle;
    if (!is_file($font_path)) { //若传入路径不存在，则退出函数且返回原图
        return $dst;
    }


    //如果颜色对象传入有误，则使用默认颜色
    if (!($rgb[0] >= 0 && $rgb[0] <= 255 && $rgb[1] >= 0 && $rgb[1] <= 255 && $rgb[2] >= 0 && $rgb[2] <= 255)) {
        $rgb = array(255, 255, 255);
    }

    //根据文本的长度，计算字符串占用的长宽
    $str_len = mb_strlen($src_string, 'utf-8');
    $src_width = $str_len * $size;
    $src_height = $size * 1.6;

    //获取目标图片的长宽
    $dst_width = imagesx($dst);
    $dst_height = imagesy($dst);

    //定义水印的6个坐标，互相组合成9个（x,y）坐标
    $left_x = $margin;  //左边的水印的横坐标
    $center_x = ($dst_width - $src_width) / 2;    //横向中间的水印的横坐标
    $right_x = $dst_width - $src_width - $margin; //右边的水印的横坐标

    $top_y = $margin + $size;   //上方水印的纵坐标
    $center_y = ($dst_height - $src_height) / 2 + $size;  //纵向中间水印的纵坐标
    $bottom_y = $dst_height - $src_height - $margin + $size;  //下方水印的纵坐标

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
            $dst_y = (float)$pos_y + $size + 10;//强制转换输入参数以消除异常输入
            break;
    }

    $src_color = imagecolorallocatealpha($dst, $rgb[0], $rgb[1], $rgb[2], $opt);
    $src_color = imagecolortransparent($dst, $src_color);

    //将文字添加到图片
    imagettftext($dst, $size, $angle, $dst_x, $dst_y, $src_color, $font_path, $src_string);
    //返回添加了水印的图片
    return $dst;
}
