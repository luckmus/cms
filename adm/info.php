<?php
if ($SystemMessage!='')
{
   print "<div class='quetion'>$SystemMessage</div><br>";
}

//print "<table border=1>";
#����� ����� �������

$HeadTable.=  "<tr>";

   #�����
$HeadTable.= "<td>";
$HeadTable.="<b>�����</b>";
$HeadTable.= "</td>";

$HeadTable.=   "<td align='CENTER'>";
$HeadTable.= "<b>�����</b>";
$HeadTable.=   "</td>";

$HeadTable.=   "<td align='CENTER'>";
$HeadTable.= "<b>����&nbsp;&nbsp;</b>";
//$HeadTable.=  "<input type='BUTTON'  value='&nbsp;&uarr;&nbsp;' onclick=\"document.location.href='?show=news&order=1';\">&nbsp;";
//$HeadTable.=  "<input type='BUTTON'  value='&nbsp;&darr;&nbsp;' onclick=\"document.location.href='?show=news&order=0';\">";

$HeadTable.=  "  </td>";
$HeadTable.=  "  <td align='CENTER'>";
$HeadTable.=  "<b>��������</b>";
$HeadTable.=  "  </td>";
$HeadTable.=  "  <td align='CENTER'>";
$HeadTable.=  "<b>������</b>";
$HeadTable.=  "  </td>";
$HeadTable.=  "  <td align='CENTER'>";
$HeadTable.=  "<b>&nbsp;</b>";
$HeadTable.=  "  </td>";
$HeadTable.=  " </tr>";
#��������� ������� ����������
if ($order=="0")
  $order= "ASC";
elseif ($order=="0")
  $order= "DESC";
$order="ASC";
$result=mQuery("SELECT id,name FROM parts pr WHERE (SELECT COUNT(id) FROM pages pg WHERE pg.pid=pr.id)>0 order by pr.ordinal");
#print "$HeadTable";
#print"</table>";
while ($r=mysql_fetch_array($result))
{
 #   print"<tr><td><div class=\"parts\">$r[1]</div><br><a href='?show=info&action=add&pid=$r[0]'>�������� ��������</a> </td></tr>";
 print" <div class=\"parts\">$r[1]</div> <a href='?show=info&action=add&pid=$r[0]'>�������� ��������</a>  <br>";
   $res=mQuery("SELECT id,pdate,name, descr, page FROM pages WHERE pid=$r[0] ORDER BY ordinal $order");
   $ordinal=0;
   print"<table border=\"1\">";
   print "$HeadTable";
   while($row=mysql_fetch_array($res))
   {
       $ordinal++;

       print " <tr>";
#       print "<td>";
#       print "</td>";
       print "<td>";
       print "<input type='BUTTON'  value='&nbsp;&uarr;&nbsp;' onclick=\"document.location.href='?show=info&action=up&id=$row[0]&pid=$r[0]';\">";
       print "<input type='BUTTON'  value='&nbsp;&darr;&nbsp;' onclick=\"document.location.href='?show=info&action=down&id=$row[0]&pid=$r[0]';\">";
       print "</td>";
       print "<td>";
       #����� �� �������
       print"$ordinal";
       print "</td>";
       #����
       print "<td>";
       print"$row[1]";
       print "</td>";
       print "<td>";
       #�������������
       print"<a alt='$row[3]' href=\"?show=info&action=edit&id=$row[0]&pid=$r[0]\">".stripslashes($row[2])."</a>";
       print "</td>";
       print "<td>";       
       print "<font color='#0000FF'>?show=info&id=$row[0]</font>";
       print "</td>";
       #��������
       print "<td>";   
       print"<a href=\"?show=info&action=del&id=$row[0]\" title=\"������� ��������\" alt=\"������� ��������\"><img src=\"../icons/delete.png\"></a>";
       print "</td>";
       print " </tr>";
       //print"</table>";
   }
   print "</table";
}
#print "</table>";
?>
