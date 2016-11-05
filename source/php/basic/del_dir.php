<?php
/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2016-11-3 21:00
 * @version:    0.1
 * @description:   遍历删除一个目录下的所有空文件夹
 */

/**
 * 遍历删除一个目录下的所有空文件夹
 * @param string $dir 目录字符串
 */
function del_dir($dir)
{
    // 首先判断传入的是否为目录，若是才执行删除的相关逻辑，否则直接跳出函数
    if (is_dir($dir)) {
        $arr = scandir($dir);   //将目录分割成数组

        if (count($arr) == 2) { //根据数组下的元素是否只有两个（.和..）来判断该目录是否为空，若是则删除该目录
            rmdir($dir);
        }
        else {  //若不使空目录，则遍历其子元素
            foreach ($arr as $item) {
                if ($item != '.' && $item != '..') {    //为了防止死循环，需要排除掉当前目录与上一级目录
                    del_dir($dir . '/' . $item);    //将元素与目录拼成完整的路径，然后使用递归再次判断
                }
            }

            /** 因为可能有目录在删除子目录后成为了空目录，所以需要在字目录遍历完后再判断一次 */
            $arr2 = scandir($dir);
            if (count($arr2) == 2) {    //遍历完子目录后还剩两个元素的，判断为空目录，将之删除
                rmdir($dir);
            }
        }

    }
}