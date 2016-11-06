<?php
/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2016-10-26 19:37
 * @version:    0.3.5
 * @description:   遍历一个目录下的所有文件和文件夹
 * 0.3：增加了前方文件夹前的箭头，并可输出根目录
 *      路径字符串传入后先将反斜杠转换会正斜杠，然后会过滤掉最后方斜线
 */

/**
 * 遍历一个目录，并将之以及其丑陋的方式显示在网页上
 * @param string $dir 要遍历的目录
 */
function listDir($dir)
{
    //处理输入的字符串的斜杠
    $dir = str_replace('\\', '/', $dir);
    $dir = rtrim($dir, '/');

    //首先判断是否存在目录，若不存在，直接退出程序
    if (!is_dir($dir)) {
        header('Content-type:text/html;charset=utf8');
        echo "<div style='color: red;'>\"$dir\"不是一个有效的目录!</div>";
        return;
    }

    //给数组排序，将文件放在文件夹前，并且剔除掉每个目录的.和..
    $arr = dir_sort($dir);

    //处理空文件夹的箭头标记与点击方法
    if (count($arr) == 0) {//空文件夹不设置箭头标记类，并将点击方法置空
        $arrow = "arrow_placeholder";
        $onclick = '';
    }
    else {//非空文件夹设置箭头标记，并设置点击方法
        $arrow = "arrow_left";
        $onclick = "show_dir(this)";
    }

    //输出目录名
    $root = basename($dir);
    $root_str = <<<root
    <div onclick='$onclick' class='dir_name' title='$root'>
        <span class='$arrow'></span>
        <span>$root</span>
    </div>\n
root;
    echo $root_str;

    //输出包裹目录内容的div
    echo "<div class='dir' hidden>";


    //遍历目录
    foreach ($arr as $item) {
        $son = $dir . '/' . $item;

        if (is_dir($son)) {//如果是文件夹，则遍历其下的文件夹
            listDir($son);//遍历该目录
        }
        else { //若是文件，则直接输出
            $item_str = <<<str
        <div class='file_name' title='$item'>
            <span class='arrow_placeholder'></span>
            <span path='$son' onclick='open_file(this)'>$item</span>
        </div>\n
str;

            echo $item_str;
        }
    }

    //关闭包裹目录内容的div
    echo "</div>";
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
