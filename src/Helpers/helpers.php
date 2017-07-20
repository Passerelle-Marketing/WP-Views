<?php 
namespace DaveJToews\WPViews\Helpers;

function canBeString($value) {
    if (is_object($value) and method_exists($value, '__toString')) return true;
    if (is_null($value)) return true;
    return is_scalar($value);
}

function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
