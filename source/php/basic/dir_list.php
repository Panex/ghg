<?php
/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2016-10-26 19:37
 * @version:    0.2
 * @description:   遍历一个目录下的所有文件和文件夹
 */

/**
 * 遍历一个目录，并将之以及其丑陋的方式显示在网页上
 * @param string $dir 要遍历的目录
 */
function listDir($dir)
{
    //首先判断是否存在目录，若不存在，直接退出程序
    if (!is_dir($dir)) {
        header('Content-type:text/html;charset=utf8');
        echo "<div style='color: red;'>\"$dir\"不是一个有效的目录!</div>";
        return;
    }

    //给数组排序，将文件放在文件夹前，并且剔除掉每个目录的.和..
    $arr = dir_sort($dir);

    //遍历目录
    foreach ($arr as $item) {
        $son = $dir . '/' . $item;

        if (is_dir($son)) {//如果是文件夹，则先输出该文件夹的文件名，然后再遍历其下的文件夹
            // $item_str = basename($item);
            $dir_str = <<<dir
              <div style='color: blue;'>
              <span style='border-bottom: 1px dashed black; padding-bottom: 2px;cursor:pointer;'>
              $item
              </span>
              </div>\n
dir;
            echo $dir_str;//输出目录名
            echo "<div class='dir'>";
            listDir($son);//遍历该目录
            echo "</div>";
        }
        else { //若是文件，则直接输出
            echo "<div style='color:green;'>" . $item . "</div>\n";
        }
    }
}


/**
 *返回包含有目录或文件名的数组，对之排序，是该数组内的文件排在文件夹前
 */
function dir_sort($dir)
{
    $dir_arr = scandir($dir);
    $new_arr_dir = array();
    $new_arr_file = array();
    foreach ($dir_arr as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (is_dir($dir . '/' . $item)) {
            $new_arr_dir[] = $item;
        }
        else {
            $new_arr_file[] = $item;
        }
    }
    return array_merge($new_arr_file, $new_arr_dir);
}
