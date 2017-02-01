<?php
//@session_start();
include "libs/vars.php";
include "libs/initvars.php";
if ($SystemMessage!='')
{
   print "<div class='quetion'>$SystemMessage</div><br>";
}

//$_SESSION['jpeg_file']  ="uploadfiles/foto_144.jpg";
//print "<img src='".GetHost()."/convertfoto.php'>";
/*
    $uri = $_SERVER['REQUEST_URI'];
    $uri = subStr($uri,1);
    $uri = subStr($uri,0,strPos($uri,"/"));
*/
        
    //$url = $_SERVER['DOCUMENT_ROOT']."/$uri/"._UploadDir;
$url = $_SERVER['DOCUMENT_ROOT']."/".getUri()._UploadDir;
$AllFilesList = LoadFromDir($url);
print "<a href='?show=upload&action=add'>Загрузить файл</a><br>";
  $pcnt=ceil(count($AllFilesList)/$CountFilesOnPage);
  $pageCounter = '';
  for($i=1; $i<=$pcnt;$i++)
  {
   if ($i!=$fpage)
   {
      //print"<a href='?show=upload&fpage=$i'>$i</a>&nbsp;&nbsp;";
      $pageCounter .= "<a href='?show=upload&fpage=$i'>$i</a>&nbsp;&nbsp;";  
   }
   else
   {
       //print"$i&nbsp;&nbsp;";
       $pageCounter .=  "$i&nbsp;&nbsp;"; 
   }
  }
  print $pageCounter;
print "<table border=1 width=100%>";
#вывод шапки таблицы
print " <tr>";
print "  <td align='CENTER'>";
print "<b>№</b>";
print "  </td>";
print "  <td align='CENTER'>";
print "<b>Ссылка на файл</b>";
print "  </td>";
print "  <td align='CENTER'>";
print "<b>Изображение</b>";
print "  </td>";
print "  <td align='CENTER'>";
print "<b>&nbsp;</b>";
print "  </td>";
print " </tr>";


$ordinal=0; 
/*
$http = "http://{$_SERVER['SERVER_NAME']}/briz/"._UploadDir;
$httpSmall = "http://{$_SERVER['SERVER_NAME']}/briz/"._UploadDir.'/'._SmallFoto.'/small_';
*/
$httpEmpty = "http://{$_SERVER['SERVER_NAME']}"._domen."/";
$http = $httpEmpty._UploadDir;
$httpSmall = $httpEmpty._UploadDir.'/'._SmallFoto.'/small_';
//foreach($AllFilesList as $f)
$startPos = ($fpage-1)*$CountFilesOnPage;
$endPos =  $startPos+$CountFilesOnPage;
if ($endPos>count($AllFilesList))
    $endPos = count($AllFilesList);
for($i=$startPos; $i<$endPos; $i++)
{                                        
    $f = $AllFilesList[$i]; 
    //print "<script>alert('2');</script>";
   $ordinal++;
   print " <tr>";
   #номер по порядку 
   print "<td valign=\"TOP\">";
   print "$ordinal";
   print "</td>";
   print "<td valign=\"TOP\">";

   #ссылка
   print "<font color='#0000FF'>$http/{$f[1]}<br>";
$imgSrc = "getsmall.php?imgname=".$f[1];
   if (isImage($f[1]))
    //print "$httpSmall{$f[1]}";
print"$httpEmpty$imgSrc";
   print "</font>";
   print "</td>";
   print "<td>";
   #изображенгие
   //global $jpeg_file;
   //$imgSrc = '../'._UploadDir.'/'._SmallFoto.'/small_'.$f[1];

//addlog($imgSrc);
   print "<div align=\"CENTER\">";
   print "<img src='../$imgSrc'>";
   print "</div>";
   print "</td>";
   print "<td>";
   #удаление
   print"<a href=\"?show=upload&action=del&fpage=$fpage&name={$f[1]}\"><img src=\"../icons/delete.png\"></a>";
   print "</td>";
   print " </tr>";
    
} 
print "</table>";
print $pageCounter; 
?>