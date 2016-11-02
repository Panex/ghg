<?php
/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2016-10-11 21:28
 * @version:    0.1
 * @description:   打印出一个变量的不同数据类型的转换
 */

/**
 * 源数据
 */
$vars = array(
    0,
    0.0,
    10,
    0.1,
    3.5,
    2147483647,    //整型最大值
    2147483648,    //大于整型的最大值
    2.234e132,
    '10a',
    'a10',
    '0',
    '0.0',
    '',
    'true',
    'false',
    'null',
    true,
    false,
    null,
    array(),
    array(0, 1, 2)
);


echo "<h1>一个变量的不同数据类型的转换</h1>";
echo "源数据数组：";
var_dump($vars);
echo "<hr>";


echo "<table border='1' cellpadding='20' cellspacing='0'>";
$thead = <<<head
    <tr>
        <td>源数据</td>
        <td>整形</td>
        <td>字符串</td>
        <td>布尔型</td>
    </tr>
head;

echo $thead;

for ($i = 0; $i < count($vars); $i++) {
    echo "<tr>";

    try {
        echo "<td>";
        var_dump($vars[$i]);
        echo "</td>";

        echo "<td>";
        $v_int = (int)$vars[$i];
        var_dump($v_int);
        echo "</td>";

        echo "<td>";
        $v_string = (string)$vars[$i];
        var_dump($v_string);
        echo "</td>";

        echo "<td>";
        $v_boolean = (boolean)$vars[$i];
        var_dump($v_boolean);
        echo "</td>";
    } catch (Exception $e) {
        print $e->getMessage();
    }
    echo "</tr>";
}
echo "</table>";