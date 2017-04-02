<?php
function Check($str)
{
    $flag = true;
    $arr  = Array();
    $arr =['<','>','\'','"','&','\\','|',';',':','`','=','{','}','[',']','/'];
    foreach ($arr as $a) {
        if (stripos($str, $a) !== false) {
            $flag = false;
            break;
        }
    }
    return $flag;
}
function Phone($str)
{
    $flag = true;
    if (strlen($str) != 10) {
        $flag = false;
    } else {
        $ar = str_split($str);
        foreach ($ar as $b) {
            if (ord($b) < 48 || ord($b) > 57) {
                $flag = false;
                break;
            }
        }
    }
    return $flag;
}
function Password($str1, $str2)
{
    $flag = true;
    if ($str1 != $str2) {
        $flag = false;
    }
    return $flag;
}
function Email($str)
{
    $flag = true;
    if (!filter_var($str, FILTER_VALIDATE_EMAIL)) {
        $flag = false;
    }
    return $flag;
}
function random_code($len)
{
    $str = "qwertyuiopasdfghjklzxcvbnm1234567890";
    $out = "";
    for ($c = 0; $c < $len; $c++) {
        $out .= substr($str, mt_rand(0, strlen($str)), 1);
    }
    return $out;
}
function prompt($prompt_msg)
{
    echo ("<script type='text/javascript'> var answer = prompt('" . $prompt_msg . "'); </script>");
    $answer = "<script type='text/javascript'> document.write(answer); </script>";
    return ($answer);
}
function confirm($confirm_msg)
{
    echo ("<script type='text/javascript'> var answer = confirm('" . $confirm_msg . "'); </script>");
    $answer = "<script type='text/javascript'> document.write(answer); </script>";
    return ($answer);
}