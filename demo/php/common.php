<?php
/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2016-11-2 19:43
 * @version:    0.1
 * @description:   定义demo需要使用的一些源码目录
 */

/** 这个__DIR__有够魔术的，在别的文件require，返回的还是本文件的路径！
 * 看来我的结论是对的，PHP脚本对路径的操作的返回值不会因位引入文件（require,include等）而改变，基准都是原来的脚本的文件，而不是引用脚本的文件！
 * 而对css、图片、js等的引用，则都是以引入文件为准的，因为这些都是浏览器处理的
 */
define("DIR_ROOT", __DIR__ . "/../..");

define("DIR_SRC", DIR_ROOT . "/source");
define("DIR_SRC_PHP", DIR_SRC . "/php");
define("DIR_SRC_JS", DIR_SRC . "/js");
define("DIR_SRC_CSS", DIR_SRC . "/css");

define("DIR_RES", DIR_ROOT . "/resource");
define("DIR_RES_IMG", DIR_RES . "/img");
define("DIR_RES_TTF", DIR_RES . "/ttf");
