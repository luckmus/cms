<?php
if ($SystemMessage!='')
{
   print "<div class='quetion'>$SystemMessage</div><br>";
}
print "<a href='?show=category&action=add'>�������� ����� ���������</a><br>";
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
$result=mQuery("SELECT id,ordinal,name FROM em_category ORDER BY ordinal");
$ordinal=0;
while($row=mysql_fetch_array($result))
{
   $ordinal++;
   print " <tr>";
   #�����
   print "<td>";
   print "<input type='BUTTON'  value='&nbsp;&uarr;&nbsp;' onclick=\"document.location.href='?show=category&action=up&id=$row[0]';\">";
   print "<input type='BUTTON'  value='&nbsp;&darr;&nbsp;' onclick=\"document.location.href='?show=category&action=down&id=$row[0]';\">";
   print "</td>";
   print "<td>";
   #����� �� �������
   print"$ordinal";
   print "</td>";
   print "<td>";
   #�������������
   print"<a href=\"?show=category&action=edit&id=$row[0]\">$row[2]</a>";
   print "</td>";
   print "<td>";
   #��������
   print"<a href=\"?show=category&action=del&id=$row[0]\"  alt=\"������� ���������\"><img src=\"../img/delete.png\"></a>";
   print "</td>";
   print " </tr>";
}
print "</table>";
?>
