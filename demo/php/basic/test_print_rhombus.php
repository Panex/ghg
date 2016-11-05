<?php
/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2016-11-5 10:30
 * @version:    0.1
 * @description:   打印任意层数的菱形
 */
$f = isset($_GET['f']) ? $_GET['f'] : 11;
$f = is_numeric($f) ? $f : 11;

printRhombus($f);

function printRhombus($floor)
{
    echo "<pre>";
    for ($i = 0; $i <= floor($floor / 2); $i++) {
        for ($k = 0; $k < $floor / 2 - $i; $k++) {
            echo " ";
        }
        for ($j = 0; $j < $i; $j++) {
            echo "* ";
        }
        echo "\n";
    }

    for ($i = $floor / 2; $i > 0; $i--) {
        for ($k = 0; $k < $floor / 2 - $i; $k++) {
            echo " ";
        }
        for ($j = 0; $j < $i; $j++) {
            echo "* ";
        }
        echo "\n";
    }
    echo "</pre>";
}