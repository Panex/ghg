<?php
/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2016-11-2 19:34
 * @version:    0.1
 * @description:   测试目录遍历功能
 */

require '../common.php';

header('Content-type:text/html;charset=gbk');
if (isset($_GET['dir'])) {
    $dir = $_GET['dir'];
}
else {
    header('Content-type:text/html;charset=utf8');
    echo "<div style='color: red;'>请输入一个有效的目录!</div>";
    exit;
}

if (empty($dir)) {
    header('Content-type:text/html;charset=utf8');
    echo "<div style='color: red;'>请输入一个有效的目录!</div>";
    exit;
}
else {
    $style = <<<style
    <style>
    .dir{
        border-left:1px dashed black;
        margin-left:15px;
        padding-left:5px;
    }
    div{
    margin:5px 0;
    }
    </style>
style;

    require DIR_SRC_PHP . "/basic/dir_list.php";
    echo $style;
    listDir($dir);
}