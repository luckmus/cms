<?php
if ($SystemMessage!='')
{
   print "<div class='quetion'>$SystemMessage</div><br>";
}
print "<table border=1>";
#����� ����� �������
print " <tr>";

print "  <td align='CENTER'>";
print "<b>�</b>";
print "  </td>";
print "  <td align='CENTER'>";
print "<b>����&nbsp;&nbsp;</b>";
print "<input type='BUTTON'  value='&nbsp;&uarr;&nbsp;' onclick=\"document.location.href='?show=ask&order=1';\">&nbsp;";
print "<input type='BUTTON'  value='&nbsp;&darr;&nbsp;' onclick=\"document.location.href='?show=ask&order=0';\">";

print "  </td>";
print "  <td align='CENTER'>";
print "<b>���������</b>";
print "  </td>";
print "  <td align='CENTER'>";
print "<b>�����</b>";
print "  </td>";
print "  <td align='CENTER'>";
print "<b>������</b>";
print "  </td>";
print "  <td align='CENTER'>";
print "<b>&nbsp;</b>";
print "  </td>" ;
print " </tr>";
#��������� ������� ����������
if ($order=="0")
  $order= "ASC";
else
  $order= "DESC";
$result=mQuery("SELECT id, quetion, answer,qname,qdate FROM ask ORDER BY qdate $order");
$ordinal=0;
while($row=mysql_fetch_array($result))
{
  if ($row[2]=='')
  {
    $row[2]="<b>��� ������</b>";
    $bgcolor="#DEF999";
    $isAnswer = false;
  }
  else
  {
    $isAnswer = true;
    if (StrLen($row[2]) >$AnswerLen)
      $row[2]=substr($row[2],0,$AnswerLen)."...";
    $row[2]="<a href=\"?show=ask&action=edit&id=$row[0]\">".stripslashes($row[2])."</a>";
     $bgcolor="";
  }
    if (StrLen($row[1]) >$AnswerLen)
      $row[1]=substr($row[1],0,$AnswerLen)."...";
   $ordinal++;
   print " <tr bgcolor= $bgcolor>";

   print "<td>";
   #����� �� �������
   print"$ordinal";
   print "</td>";
   #����
   print "<td>";
   print"<font size=2>$row[4]</font>";
   print "</td>";
   print "<td>";
   #������
   print"<a href=\"?show=ask&action=edit&id=$row[0]\">".stripslashes($row[1])."</a>";
   print "</td>";
   print "<td>";
   #�����
   if ($isAnswer)
        print "��������";
   else
        print "��� ������";

   print "</td>";
   print "  <td align='CENTER'>";
   print "<font color='#0000FF'>?show=ask&id=$row[0]&apage=1</font>";
   print "  </td>";   
   print "<td>";
   #��������
   print"<a href=\"?show=ask&action=del&id=$row[0]\"  title=\"������� ������\"><img src=\"../icons/delete.png\"></a>";
   print "</td>";
   print " </tr>";
}
print "</table>";
?>
