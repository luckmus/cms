<?php
if ($SystemMessage!='')
{
   print "<div class='quetion'>$SystemMessage</div><br>";
}
print "<a href='?show=news&action=add'>�������� �������</a><br>";
print "<table border=1>";
#����� ����� �������
print " <tr>";

print "  <td align='CENTER'>";
print "<b>�</b>";
print "  </td>";
print "  <td align='CENTER'>";
print "<b>����&nbsp;&nbsp;</b>";
print "<input type='BUTTON'  value='&nbsp;&uarr;&nbsp;' onclick=\"document.location.href='?show=news&order=1';\">&nbsp;";
print "<input type='BUTTON'  value='&nbsp;&darr;&nbsp;' onclick=\"document.location.href='?show=news&order=0';\">";

print "  </td>";
print "  <td align='CENTER'>";
print "<b>���������</b>";
print "  </td>";
print "  <td align='CENTER'>";
print "<b>������</b>";
print "  </td>";
print "  <td align='CENTER'>";
print "<b>&nbsp;</b>";
print "  </td>";
print " </tr>";
#��������� ������� ����������
if ($order=="0")
  $order= "ASC";
else
  $order= "DESC";
$result=mQuery("SELECT id,ndate,name FROM news ORDER BY ndate $order");
$ordinal=0;
while($row=mysql_fetch_array($result))
{
   $ordinal++;
   print " <tr>";

   print "<td>";
   #����� �� �������
   print"$ordinal";
   print "</td>";
   #����
   print "<td>";
   print"<font size=2>$row[1]</font>";
   print "</td>";
   print "<td>";
   #�������������
   print"<a href=\"?show=news&action=edit&id=$row[0]\">".stripslashes($row[2])."</a>";
   print "</td>";
   print "<td>";
   #������
   print"<font color='#0000FF'>?show=news&id=$row[0]&npage=1</font>";
   print "</td>";
   print "<td>";
   #��������
   print"<a href=\"?show=news&action=del&id=$row[0]\"  title=\"������� �������\"><img src=\"../icons/delete.png\"></a>";
   print "</td>";
   print " </tr>";
}
print "</table>";
?>
