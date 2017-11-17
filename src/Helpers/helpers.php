<?php 
namespace DaveJToews\WPViews\Helpers;

function can_be_string($value) {
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

function is_body_paginated($content) {
    return strpos( $content, '<!--nextpage-->' );
}

function get_body_pages($content) {
    return explode('<!--nextpage-->', $content);
}


