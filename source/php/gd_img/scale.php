<?php
/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2016-10-30 21:01
 * @version:    0.1
 * @function:   将一张图片横纵方向独立地任意尺寸缩放
 */

/**
 * @param resource $img 需要缩放的图片对象
 * @param int $scale_x 横轴反向的缩放比例
 * @param int $scale_y 纵轴反向的缩放比例
 * @return bool|resource    成功则返回缩放后的图片对象，否则返回false
 */
function scaleImage($img, $scale_x = 1, $scale_y = 1)
{
    /** 检查非法输入，若有非法输入则将值置为1 */
    $scale_x = $scale_x > 0 && $scale_x <= 10 ? (float)$scale_x : 1;
    $scale_y = $scale_y > 0 && $scale_y <= 10 ? (float)$scale_y : 1;

    //如果尺寸过大，可能会内存溢出，因此限制放大倍数不能大于10，但是依然存在图片过大而放大后内存溢出的风险
    if ($scale_x + $scale_y > 10) {
        $scale_x = 1;
        $scale_y = 1;
    }

    /** 获取图片的尺寸 */
    $width = imagesx($img);
    $height = imagesy($img);

    /** 计算缩放后的尺寸*/
    $scale_width = $width * $scale_x;
    $scale_height = $height * $scale_y;

    //创建缩放后的载体对象
    $scale = imagecreatetruecolor($scale_width, $scale_height);

    //缩放图片后存储至载体并返回
    if (imagecopyresampled($scale, $img, 0, 0, 0, 0, $scale_width, $scale_height, $width, $height)) {
        return $scale;
    }
    else {
        return false;
    }
}