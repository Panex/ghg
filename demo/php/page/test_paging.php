<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        a[pageStatus='enabled'] {
            padding: 5px;
            border: 1px solid black;
            text-decoration: none;
            margin: 5px;
        }

        a[pageStatus='disabled'] {
            padding: 5px;
            margin: 5px;
            text-decoration: none;
            color: gray;
            cursor: default;
        }

        a[pageStatus='dots'] {
            text-decoration: none;
            color: gray;
            cursor: default;
        }

        a[pageStatus='current'] {
            text-decoration: none;
            font-weight: bolder;
            color: black;
            cursor: default;
            padding: 5px;
            margin: 5px;
        }

        .paging_input {
            width: 50px;
        }
    </style>
</head>
<body>

<?php
/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2016-11-1 18:46
 * @version:    0.1
 * @function:   测试分页
 */
require '../common.php';
require DIR_SRC_PHP . '/page/newPaging.php';
$pages = isset($_GET['p']) ? $_GET['p'] : 20;//总页码数
$cur = isset($_GET['c']) ? $_GET['c'] : 1;//当前页码数

$str = paging($pages, $cur, "test_paging.php?p=$pages&c=");

echo $str;
?>
</body>
</html>
