<?php
$stop=0;
$ErrorMes="";
 global          $issend;
if (isset($issend))
{
   if($qname=="")
   {
      $ErrorMes="<font color='red'>���� <b>���</b> �� ���������.</font><br>";
      $stop=1;
   }
   if($email=="")
   {
      $ErrorMes.="<font color='red'>���� <b>email</b> �� ���������.</font><br>";
      $stop=1;
   }
   elseif (!ereg("^.+@.+\\..+$",$email))
   {
      $ErrorMes.="<font color='red'><b>email</b> ������ �� ���������.</font><br>";
      $stop=1;
   }
   if($qtext=="")
   {
      $ErrorMes.="<font color='red'>���� <b>������</b> �� ���������.</font><br>";
      $stop=1;
   }
   #���� ������ ��� ��������, �� �������� ����������� �����
   if ($stop==0)
   if ($cd=="")
   {
      $ErrorMes="<font color='red'>����������� ����� �� ��������.</font><br>";
      $stop=1;
   }
   elseif ($cd!=$_SESSION['contrdig'])
   {
      $ErrorMes="<font color='red'>����������� ����� �������� �� �����.</font><br>";
      $stop=1;
   }
}

if ((!isset($issend)) || ($stop==1))
{
   $qname=stripslashes($qname);
   $email=stripslashes($email);
   $qtext=stripslashes($qtext);

   print"$ErrorMes";
   #����� ��������� �������
   print "<div class='descr' align='CENTER'>������ ������</div>";
   print "<form method=POST onsubmit=\"document.getElementById('idsave').value='���������';\">";
   print "���� ��� <font color='red'>*</font><br>";
   print"  <input type='text' name='qname' size=30 maxlength=50 value='$qname'><br>";
   print "email <font color='red'>*</font><br>";
   print"  <input type='text' name='email' size=30 maxlength=255 value='$email'><br>";
   print "������ <font color='red'>*</font><br>";
   print " <textarea name='qtext' rows=\"7\" cols=\"50\" class=\"textareabig\" >$qtext</textarea><br>";
   //print "����������� ����� <font color='red'>*</font><br><input type='text' name='contrdig' size=5 maxlength=5>  <img src='http://127.0.0.1/altera/controldig.php'><a onclick='document.forms[0].submit();' style='cursor:hand'>��������</a>";
   $cntrlDig = GetHost()."controldig.php";
   print "����������� ����� <font color='red'>*</font><br><input type='text' name='contrdig' size=5 maxlength=5>  <img src=\"$cntrlDig\" id=\"cntrldg\"></img><span onclick=\"refreshControlDig('cntrldg')\" style=\"cursor:pointer\">��������</span>";
  # print "<div style='cursor:hand' id='im'   onclick=\"document.forms[0].submit();\">��������</div> <br><br>";
   print "<br><br>";
   print "<input type='SUBMIT' id='idsave' name='issend'   class=\"submitbig\" value='���������'>";
   print"</form>";
   print "<font color='red'>*</font> ����, ������������ ��� �����.";
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
     $comminc->sendMailToManager("������ �� ����� ".getHost(), "����� ������ �� �����: \"$qtext\"");       
     print "��� ������ ��������. ����� �� ���� ����� ��������� �� ��� email, � ����� ����� �������� �� ����� �����.";
   }
}

?>
