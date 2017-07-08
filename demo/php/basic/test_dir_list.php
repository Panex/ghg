<?php
/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2016-11-2 19:34
 * @version:    0.2
 * @description:   测试目录遍历功能
 * 0.2：增加了文件夹展开功能（js)
 */

require '../common.php';
?>
<!doctype html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DIR LIST</title>
	<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.js"></script>
    <script>
        function show_dir(obj) {
            //切换目录下的文件区(next('div.dir'))的展开情况
            $(obj).next('div.dir').toggle();
            //将下级所有目录都收起（隐藏）
            $(obj).next('div.dir').children('div.dir').hide();
            //更改下级所有目录转成向下的箭头（移除向下箭头的样式）
            $(obj).next('div.dir').find('div.dir_name').find('span:first').removeClass("arrow_down");
            //切换本目录的箭头样式（通过移除与添加向下的箭头方式实现）
            $(obj).children('span:first').toggleClass("arrow_down");
        }
        function open_file(obj) {
            console.log($(obj).attr('path'));
        }
    </script>
    <style>
        .file_name {
            color: black;
            margin: 5px 0;
            cursor: pointer;
        }

        .dir_name {
            color: dodgerblue;
            margin: 5px 0;
            font-size: 20px;
            cursor: pointer;
        }

        .dir {
            border-left: 1px dashed cornflowerblue;
            margin-left: 25px;
            padding-left: 5px;
        }

        .arrow_placeholder {
            display: inline-block;
            width: 10px;
            height: 10px;
        }

        .arrow_left {
            display: inline-block;
            width: 0;
            height: 0;
            border-top: 5px solid white;
            border-bottom: 5px solid white;
            border-left: 10px solid black;
            border-right: 0 solid white;
        }

        .arrow_down {
            display: inline-block;
            width: 0;
            height: 0;
            border-top: 10px solid black;
            border-bottom: 0 solid white;
            border-left: 5px solid white;
            border-right: 5px solid white;
        }

        div {
            margin: 5px 0;
        }

        #left_dir {
            width: 300px;
            height: 600px;
            overflow: auto;
            white-space: nowrap;
            border-right: 1px solid black;
        }
    </style>
</head>
<body>
<?php
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
    require DIR_SRC_PHP . "/basic/dir_list.php";
    echo "<div id='left_dir'>";
    listDir($dir);
    echo "</div>";
}
?>

</body>
</html>
