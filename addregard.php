<?php
$stop=0;
$ErrorMes="";

if (isset($isrsend))
{
   if($rname=="")
   {
      $ErrorMes="<font color='red'>���� <b>���</b> �� ���������.</font><br>";
      $stop=1;
   }
   if($rtext=="")
   {
      $ErrorMes.="<font color='red'>���� <b>�����</b> �� ���������.</font><br>";
      $stop=1;
   }
   #���� ������ ��� ��������, �� �������� ����������� �����
   if ($stop==0)
   if ($rcd=="")
   {
      $ErrorMes="<font color='red'>����������� ����� �� ��������.</font><br>";
      $stop=1;
   }
   elseif ($rcd!=$_SESSION['contrdig'])
   {
      $ErrorMes="<font color='red'>����������� ����� �������� �� �����.</font><br>";
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
   #����� ���������� ������
   print "<div class='descr' align='CENTER'>�������� ������ � �����</div>";
   print "<form method=POST>";
   print "���� ��� <font color='red'>*</font><br>";
   print"  <input type='text' name='rname' size=30 maxlength=50 value='$rname'><br>";
   print "��������<br>";
   print"  <input type='text' name='firm' size=30 maxlength=100 value='$firm'><br>";
   print "���������<br>";
   print"  <input type='text' name='position' size=30 maxlength=100 value='$position'><br>";
   print "����� <font color='red'>*</font><br>";
   print " <textarea  rows=\"7\" cols=\"50\" class=\"textareabig\" name='rtext'>$rtext</textarea><br>";
   //print "����������� ����� <font color='red'>*</font><br><input type='text' name='rcontrdig' size=5 maxlength=5>  <img src='controldig.php'><a onclick='document.forms[0].submit();' style='cursor:hand'>��������</a>";
   $cntrlDig = GetHost()."controldig.php";
   print "����������� ����� <font color='red'>*</font><br><input type='text' name='rcontrdig' size=5 maxlength=5>  <img src=\"$cntrlDig\" id=\"cntrldg\"></img><span onclick=\"refreshControlDig('cntrldg')\" style=\"cursor:pointer\">��������</span>";
   
  // print "<div style='cursor:hand' id='im'   onclick=\"document.forms[0].submit();\">��������</div> <br><br>";
   print "<br><br>";
   print "<input type='SUBMIT'  class=\"submitbig\"  name='isrsend' value='���������'>";
   print"</form>";
   print "<font color='red'>*</font> ����, ������������ ��� �����.";
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
     $comminc->sendMailToManager("����� �� ����� ".getHost(), "����� ����� �� �����: \"$rtext\"");
     print "<b>��� ����� ��������.</b><br>";
     showAllregards();
   }
}
?>
