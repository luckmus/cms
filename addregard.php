<?php
$stop=0;
$ErrorMes="";

if (isset($isrsend))
{
   if($rname=="")
   {
      $ErrorMes="<font color='red'>Поле <b>Имя</b> не заполнено.</font><br>";
      $stop=1;
   }
   if($rtext=="")
   {
      $ErrorMes.="<font color='red'>Поле <b>Отзыв</b> не заполнено.</font><br>";
      $stop=1;
   }
   #если прощли все проверки, то проверим контрольное число
   if ($stop==0)
   if ($rcd=="")
   {
      $ErrorMes="<font color='red'>Контрольное число не введенно.</font><br>";
      $stop=1;
   }
   elseif ($rcd!=$_SESSION['contrdig'])
   {
      $ErrorMes="<font color='red'>Контрольное число введенно не верно.</font><br>";
      $stop=1;
   }
}


if ((!isset($isrsend)) || ($stop==1))
{

   $rname=stripslashes($rname);
   $firm=stripslashes($firm);
   $position=stripslashes($position);
   $rtext=stripslashes($rtext);

   print"$ErrorMes";
   #форма оставления отзыва
   print "<div class='descr' align='CENTER'>Оставить запись в книге</div>";
   print "<form method=POST>";
   print "Ваше имя <font color='red'>*</font><br>";
   print"  <input type='text' name='rname' size=30 maxlength=50 value='$rname'><br>";
   print "Компания<br>";
   print"  <input type='text' name='firm' size=30 maxlength=100 value='$firm'><br>";
   print "Должность<br>";
   print"  <input type='text' name='position' size=30 maxlength=100 value='$position'><br>";
   print "Отзыв <font color='red'>*</font><br>";
   print " <textarea  rows=\"7\" cols=\"50\" class=\"textareabig\" name='rtext'>$rtext</textarea><br>";
   //print "Контрольное число <font color='red'>*</font><br><input type='text' name='rcontrdig' size=5 maxlength=5>  <img src='controldig.php'><a onclick='document.forms[0].submit();' style='cursor:hand'>Обновить</a>";
   $cntrlDig = GetHost()."controldig.php";
   print "Контрольное число <font color='red'>*</font><br><input type='text' name='rcontrdig' size=5 maxlength=5>  <img src=\"$cntrlDig\" id=\"cntrldg\"></img><span onclick=\"refreshControlDig('cntrldg')\" style=\"cursor:pointer\">Обновить</span>";
   
  // print "<div style='cursor:hand' id='im'   onclick=\"document.forms[0].submit();\">Обновить</div> <br><br>";
   print "<br><br>";
   print "<input type='SUBMIT'  class=\"submitbig\"  name='isrsend' value='Отправить'>";
   print"</form>";
   print "<font color='red'>*</font> Поле, обязательное для ввода.";
}
else
{
   $rname=addslashes($rname);
   $firm=addslashes($firm);
   $position=addslashes($position);
   $rtext=addslashes($rtext);
   $qdate=date('Y-m-d H:i:s');
   $result=mQuery("INSERT INTO regards(name,rdate,firm,position,regard ) VALUES('$rname','$qdate','$firm','$position','$rtext' )");
   if($result)
   {
     require_once "modules/em/usercommunication.php";
     $comminc = new UserCommunication();
     $comminc->init();
     $comminc->sendMailToManager("Отзыв на сайте ".getHost(), "Новый отзыв на сайте: \"$rtext\"");
     print "<b>Ваш отзыв размещен.</b><br>";
     showAllregards();
   }
}
?>
