<?php
function isImage($s)
{    
     $result = false;
     $str = subStr(strtolower($s),StrLen($s)-4,StrLen($s));
     if ($str == '.jpg') 
     {
        $result = true; 
     }
     return $result;
}
function getUri()
{
    if (_is_inet == 0)
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = subStr($uri,1);
        $uri = subStr($uri,0,strPos($uri,"/"));
    }
    else
        $uri = '';
    return "$uri/";
}
function convertToWIN1251($text){
    $s = $text;
    $text = htmlspecialchars(urldecode($text));
    $text = iconv('UTF-8', 'windows-1251', $text);    
    if($text=="")$text = $s;    
    
    return $text;
    
}
?>