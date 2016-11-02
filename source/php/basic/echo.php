<?php
/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2016-10-13 10:42
 * @version:    0.1
 * @description:   测试echo,print,print_r,var_dump,sprintf输出变量的不同
 */

$v = array(
    100,
    '100',
    true,
    false,
    array(10, 20, 30),
    '中文'
);
echo "<h1>echo,print,print_r,var_dump,sprintf输出变量的不同</h1>";
echo "源数据数组：";
var_dump($v);
echo "<hr>";
echo "<table border='1' cellpadding='20'>";
$thead = <<<thead
    <tr>
        <td>echo</td>
        <td>print</td>
        <td>print_r</td>
        <td>var_dump</td>
        <td>sprintf</td>
    </tr>
thead;
echo $thead;

for ($i = 0; $i < count($v); $i++) {
    echo "<tr>";

    echo "<td>";
    echo $v[$i];
    echo "</td>";

    echo "<td>";
    print($v[$i]);
    echo "</td>";

    echo "<td>";
    print_r($v[$i]);
    echo "</td>";

    echo "<td>";
    var_dump($v[$i]);
    echo "</td>";

    echo "<td>";
    echo sprintf('%d', $v[$i]);
    echo "</td>";

    echo "</tr>";
}

echo "</table>";