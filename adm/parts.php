<?php
if ($SystemMessage!='')
{
   print "<div class='quetion'>$SystemMessage</div><br>";
}
print "<a href='?show=parts&action=add'>�������� ����� ������</a><br>";
print "<table border=1>";
#����� ����� �������
print " <tr>";
print "  <td align='CENTER'>";
print "<b>�����</b>";
print "  </td>";
print "  <td align='CENTER'>";
print "<b>�</b>";
print "  </td>";
print "  <td align='CENTER'>";
print "<b>������������</b>";
print "  </td>";
print "  <td align='CENTER'>";
print "<b>&nbsp;</b>";
print "  </td>";
print " </tr>";
$result=mQuery("SELECT id,ordinal,name FROM parts ORDER BY ordinal");
$ordinal=0;
while($row=mysql_fetch_array($result))
{
   $ordinal++;
   print " <tr>";
   #�����
   print "<td>";
   print "<input type='BUTTON'  value='&nbsp;&uarr;&nbsp;' onclick=\"document.location.href='?show=parts&action=up&id=$row[0]';\">";
   print "<input type='BUTTON'  value='&nbsp;&darr;&nbsp;' onclick=\"document.location.href='?show=parts&action=down&id=$row[0]';\">";
   print "</td>";
   print "<td>";
   #����� �� �������
   print"$ordinal";
   print "</td>";
   print "<td>";
   #�������������
   print"<a href=\"?show=parts&action=edit&id=$row[0]\">$row[2]</a>";
   print "</td>";
   print "<td>";
   #��������
   print"<a href=\"?show=parts&action=del&id=$row[0]\"  alt=\"������� ������\"><img src=\"../img/delete.png\"></a>";
   print "</td>";
   print " </tr>";
}
print "</table>";
?>
