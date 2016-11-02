<?php

/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2016-10-13 14:11
 * @version:    0.0
 * @description:   使用is_null(),isset(),empty(),is_scalar()来判断不同的变量的结果，并以表格输出
 */
class Person
{
    function call()
    {

    }
}

$p = new Person();

$v = array(
    0,
    0.0,
    "",
    '0',
    false,
    true,
    null,
    '0.0',
    array(),
    array(1, 2, 3),
    $p
);

echo "<h1>使用is_null(),isset(),empty(),is_scalar()来判断不同的变量的结果</h1>";
echo "源数据数组：";
var_dump($v);
echo "<hr>";

echo "<table border='1' cellpadding='20' cellspacing='0'>";

$thead = <<<thead
    <tr>
        <td>源数据</td>
        <td>is_null()</td>
        <td>empty()</td>
        <td>isset()</td>
        <td>is_scalar()</td>
    </tr>
thead;


echo $thead;

for ($i = 0; $i <= count($v); $i++) {
    echo "<tr>";

    echo "<td>";
    var_dump($v[$i]);
    echo "</td>";

    echo "<td>";
    var_dump(is_null($v[$i]));
    echo "</td>";

    echo "<td>";
    var_dump(empty($v[$i]));
    echo "</td>";

    echo "<td>";
    var_dump(isset($v[$i]));
    echo "</td>";

    echo "<td>";
    var_dump(is_scalar($v[$i]));
    echo "</td>";

    echo "</tr>";
}

echo "</table>";

$comment = <<<comment
    <h3>
        *最后一行是未定义的变量，使用var_dump输出会报错，
        用is_null()、is_scalar()也会报错，但是isset()和empty()不会报错
    </h3>
comment;

echo $comment;