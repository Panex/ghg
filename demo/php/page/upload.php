<?php
/**
 * 获取上传的文件，并将之保存至指定的文件夹
 *  version 0.1
 */

require '../common.php';
require DIR_SRC_PHP . '/page/save_upload_file.php';

var_dump($_FILES);
if (!isset($_FILES['up_file'])) {
    echo "上传出错";
    exit;
}
$file_array = array(
    '.jpg',
    '.jpeg',
    '.png',
    '.gif'
);
$file = [];
for ($i = 0; $i < count($_FILES['up_file']['name']); $i++) {
    $file['name'] = $_FILES['up_file']['name'][$i];
    $file['type'] = $_FILES['up_file']['type'][$i];
    $file['tmp_name'] = $_FILES['up_file']['tmp_name'][$i];
    $file['error'] = $_FILES['up_file']['error'][$i];
    $file['size'] = $_FILES['up_file']['size'][$i];

    $r = saveUploadedFile($file, DIR_RES_IMG . '/upimg/', 3, 6, 0, $file_array);
    if ($r[0]) {
        echo $r[2], "上传成功<br>";
    }
    var_dump($r);
}


