<?php
/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2016-10-30 16:00
 * @version:    0.3
 * @function:   保存上传的文件
 *
 * 0.3：修改了文件类型控制，使用数组来判断多个自定义的文件类型，预定义的类型控制依然保留
 *
 */

/**
 * @param array $file $_FILES的单个文件的信息数组
 * @param string $dir 保存文件路径
 * @param int $filesize 文件大小限制，单位M，默认3
 * @param int $name_extra_length 保存文件生成的随机文件名的扩展部分长度，默认6
 * @param int $file_type 文件类型，1：图片；2：文本文件；默认1；3：声音文件；4：视频文件；5：应用文件；0：自定义类型
 * @param string $self_type 特定文件类型数组，只有file_type为0时才有效，必须带“.”
 * @return mixed    $return_msg[0]:文件是否上传成功；$return_msg[1]:文件上传失败的错误码；$return_msg[2]:文件错误提示信息，若$return_msg[0]==true,则返回的为保存的文件名
 */
function saveUploadedFile($file, $dir, $filesize = 3, $name_extra_length = 6, $file_type = 1, $self_type = array())
{
    if (!is_dir($dir)) {
        $return_msg[0] = false;
        $return_msg[1] = -3;
        $return_msg[2] = '文件保存目录错误';
        return $return_msg;
    }

    //空参数传递
    if (!isset($file)) {
        $return_msg[0] = false;
        $return_msg[1] = -2;
        $return_msg[2] = '参数传递错误';
        return $return_msg;
    }

    //初始化回参数
    $return_msg[0] = false;
    $return_msg[1] = -1;
    $return_msg[2] = '未知错误';

    //检查上传问题
    if ($file['error'] != 0) {
        $return_msg[0] = false;
        $return_msg[1] = $file['error'];
        $return_msg[2] = '文件上传时发生错误';
        return $return_msg;
    }

    //检查文件大小
    $size = $filesize * 1024 * 1024;
    if ($file['size'] > $size) {
        $return_msg[0] = false;
        $return_msg[1] = 11;
        $return_msg[2] = "文件超出制定大小($filesize MB)";
        return $return_msg;
    }

    //截取信息中的type字段
    $type_str = strstr($file['type'], '/', true);
    //从上传的文件名处截取文件后缀
    $file_suffix = strrchr($file['name'], '.');

    switch ($file_type) {
        case 0: //自定义类型，需要完整地字符串，形如application/octet-stream
            $need_type = $self_type;
            break;
        //模糊类型，只需要识别类型即可
        case 1:
            $need_type = 'image';
            break;
        case 2:
            $need_type = 'text';
            break;
        case 3:
            $need_type = 'audio';
            break;
        case 4:
            $need_type = 'video';
            break;
        case 5:
            $need_type = 'application';
            break;
        default:
            //未给出定义的类型将退出函数
            $return_msg[0] = false;
            $return_msg[1] = 12;
            $return_msg[2] = "文件类型参数未知";
            return $return_msg;

    }
    if ($file_type != 0 && $type_str != $need_type) {//预定义文件类型只需要比较类型字串
        $return_msg[0] = false;
        $return_msg[1] = 12;
        $return_msg[2] = "不是指定的文件类型,当前文件类型为[$file[type]]，需要的文件类型为$need_type";
        return $return_msg;
    }
    else if ($file_type == 0 && !in_array($file_suffix, $need_type)) {//自定义类型需要完整比较
        $return_msg[0] = false;
        $return_msg[1] = 12;
        $s = '';
        foreach ($need_type as $item) {
            $s .= '[' . $item . "]";
        }
        $return_msg[2] = "不是指定的文件类型,当前文件类型为[" . $file_suffix . "]，需要的类型为" . $s;
        return $return_msg;
    }

    //获取临时文件名
    $tmp_file = $file['tmp_name'];

    //格式保存文件夹，处理带/和不带/的情况（事实上不需要特意处理，多一个/并不影响）
    $upload_dir = rtrim($dir, '/') . '/';
//    $upload_dir = $dir . "/";
    //获取随机的文件名，并拼上后缀组成新文件名
    $new_name = getRandName($name_extra_length) . $file_suffix;
    //新文件名加上保存文件夹组成保存函数的保存文件名
    $stored_filename = $upload_dir . $new_name;
    //将临时文件保存至目的文件处，并获取返回值
    $result = move_uploaded_file($tmp_file, $stored_filename);

    //判断保存上传文件的结果，根据不同的结果返回不同的代码
    if ($result) {
        $return_msg[0] = true;
        $return_msg[1] = 0;
        $return_msg[2] = $new_name;
        return $return_msg;
    }
    else {
        $return_msg[0] = false;
        $return_msg[1] = 13;
        $return_msg[2] = '移动文件失败';
        return $return_msg;
    }
}

/**
 * 随机生成由当前时间与若干随机字符组成的一个字符串
 * @param  integer $extra_length 文件名的扩展字符长度，最小为1，非法输入将被置为6；
 * @return string                生成的date_extra字符串
 */
function getRandName($extra_length = 6)
{
    $extra_length = $extra_length >= 1 ? $extra_length : 6;
    $date = date('YmdHis');
    $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    $c_len = strlen($characters);
    $extra = '';
    for ($i = 0; $i < $extra_length; $i++) {
        $extra .= $characters[mt_rand(0, $c_len - 1)];
    }
    return $date . '_' . $extra;
}
