<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('random_number')) {

    function random_number($length)
    {
        $str = "";
        $characters = array_merge(range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }
}
