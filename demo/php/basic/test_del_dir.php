<?php
/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2016-11-5 10:17
 * @version:    0.1
 * @description:   测试删除文件夹
 */
require '../common.php';
require DIR_SRC_PHP . "/basic/del_dir.php";

if (isset($_GET['dir']) && is_dir($_GET['dir'])) {
    $dir = $_GET['dir'];
    del_dir($dir);
}
else {
    echo "请输入正确的目录";
    exit;
}

