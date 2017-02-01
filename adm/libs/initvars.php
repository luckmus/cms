<?php
$show=$_GET['show'];
if ($show=="") $show=$_POST['show'];
#определяю  с каким справочником работаю
switch ($show)
{
  case "parts":
       $dir="parts";
  break;
  case "news":
       $dir="news";
  break;
  case "info":
       $dir="pages";
  break;
  case "regards":
       $dir="regards";
  break;
  case "ask":
       $dir="ask";
  break;
  case "category":
       $dir="em_category";
  break;  
  case "goods":
       $dir="em_goods";
  break;    
  case "orders":
       $dir="em_order";
  break;  
  default:
      $dir="";
  break;
}

$action=$_POST['action'];
if ($action=="") $action=$_GET['action'];

$category=$_POST['category'];
if ($category=='')
    $category=$_GET['category'];
    
$goods=$_POST['goods'];
if ($goods=='')
    $goods=$_GET['goods']; 
    
$issave=$_POST['issave'];
if ($issave=='')
    $issave=$_GET['issave']; 

$imagefile=$_POST['imagefile'];
if ($imagefile=='')
    $imagefile=$_GET['imagefile'];     
    
$fpage=$_GET['fpage']; 
if (trim($fpage) == '')
    $fpage = 1;

$field = $_GET['field'];    
$ord   = $_GET['ord'];    
    
$name=$_POST['name'];
if ($name=='')
    $name=$_GET['name'];
    
$managerdesc =$_POST['managerdesc']; 
$iscomplete  =$_POST['iscomplete']; 

    
$quetion=$_POST['quetion'];
$answer=$_POST['answer'];
//$name=addslashes($name);
$news=$_POST['news'];
//$news=addslashes($news);
$page=$_POST['page'];
$price=$_POST['price']; 
$descr=$_POST['descr'];
$metadescr=$_POST['metadescr'];
$metawords=$_POST['metawords'];


$isInclude=$_POST['isinclude'];
if ($isInclude=="") $isInclude=$_GET['isinclude'];

$pid=$_POST['pid'];
if ($pid=="") $pid=$_GET['pid'];

$pid=$_POST['pid'];
if ($pid=="") $pid=$_GET['pid'];

$pidsel=$_POST['pidsel'];
if ($pidsel=="") $pidsel=$_GET['pidsel'];



$id=$_GET['id'];
if ($id=="") $id=$_POST['id'];

#переменная в которую буду выводить всякие сообщения
$SystemMessage="";

#порядок сортировки
$order=$_GET['order'];
if ($order=="") $order=$_POST['order'];

?>