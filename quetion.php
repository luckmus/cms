<?php
$stop=0;
$ErrorMes="";
 global          $issend;
if (isset($issend))
{
   if($qname=="")
   {
      $ErrorMes="<font color='red'>Поле <b>Имя</b> не заполнено.</font><br>";
      $stop=1;
   }
   if($email=="")
   {
      $ErrorMes.="<font color='red'>Поле <b>email</b> не заполнено.</font><br>";
      $stop=1;
   }
   elseif (!ereg("^.+@.+\\..+$",$email))
   {
      $ErrorMes.="<font color='red'><b>email</b> введен не корректно.</font><br>";
      $stop=1;
   }
   if($qtext=="")
   {
      $ErrorMes.="<font color='red'>Поле <b>Вопрос</b> не заполнено.</font><br>";
      $stop=1;
   }
   #если прощли все проверки, то проверим контрольное число
   if ($stop==0)
   if ($cd=="")
   {
      $ErrorMes="<font color='red'>Контрольное число не введенно.</font><br>";
      $stop=1;
   }
   elseif ($cd!=$_SESSION['contrdig'])
   {
      $ErrorMes="<font color='red'>Контрольное число введенно не верно.</font><br>";
      $stop=1;
   }
}

if ((!isset($issend)) || ($stop==1))
{
   $qname=stripslashes($qname);
   $email=stripslashes($email);
   $qtext=stripslashes($qtext);

   print"$ErrorMes";
   #форма задавания вопроса
   print "<div class='descr' align='CENTER'>Задать вопрос</div>";
   print "<form method=POST onsubmit=\"document.getElementById('idsave').value='Отправить';\">";
   print "Ваше имя <font color='red'>*</font><br>";
   print"  <input type='text' name='qname' size=30 maxlength=50 value='$qname'><br>";
   print "email <font color='red'>*</font><br>";
   print"  <input type='text' name='email' size=30 maxlength=255 value='$email'><br>";
   print "Вопрос <font color='red'>*</font><br>";
   print " <textarea name='qtext' rows=\"7\" cols=\"50\" class=\"textareabig\" >$qtext</textarea><br>";
   //print "Контрольное число <font color='red'>*</font><br><input type='text' name='contrdig' size=5 maxlength=5>  <img src='http://127.0.0.1/altera/controldig.php'><a onclick='document.forms[0].submit();' style='cursor:hand'>Обновить</a>";
   $cntrlDig = GetHost()."controldig.php";
   print "Контрольное число <font color='red'>*</font><br><input type='text' name='contrdig' size=5 maxlength=5>  <img src=\"$cntrlDig\" id=\"cntrldg\"></img><span onclick=\"refreshControlDig('cntrldg')\" style=\"cursor:pointer\">Обновить</span>";
  # print "<div style='cursor:hand' id='im'   onclick=\"document.forms[0].submit();\">Обновить</div> <br><br>";
   print "<br><br>";
   print "<input type='SUBMIT' id='idsave' name='issend'   class=\"submitbig\" value='Отправить'>";
   print"</form>";
   print "<font color='red'>*</font> Поле, обязательное для ввода.";
}
else
{
   $qname=addslashes($qname);
   $email=addslashes($email);
   $qtext=addslashes($qtext);
   $qdate=date('Y-m-d H:i:s');
   $result=mQuery("INSERT INTO ask(quetion,qdate,qname,email ) VALUES('$qtext','$qdate','$qname','$email' )");
   if($result)
   {
     require_once "modules/em/usercommunication.php";
     $comminc = new UserCommunication();
     $comminc->init();
     $comminc->sendMailToManager("Вопрос на сайте ".getHost(), "Новый вопрос на сайте: \"$qtext\"");       
     print "Ваш вопрос размещен. Ответ на него будет отправлен на Ваш email, а также будет размещен на нашем сайте.";
   }
}

?>
