<?php
if ($SystemMessage!='')
{
   print "<div class='quetion'>$SystemMessage</div><br>";
}

//print "<table border=1>";
#����� ����� �������

$HeadTable.=  "<tr>";

   #�����
$HeadTable.=   "<td align='CENTER'>";
$HeadTable.= "<b>� �/�</b>";
$HeadTable.=   "</td>";

$HeadTable.=   "<td align='CENTER'>";
$HeadTable.= "<b>����&nbsp;&nbsp;</b>";
$HeadTable.=  "<input type='BUTTON'  value='&nbsp;&uarr;&nbsp;' onclick=\"document.location.href='?show=regards&order=1';\">&nbsp;";
$HeadTable.=  "<input type='BUTTON'  value='&nbsp;&darr;&nbsp;' onclick=\"document.location.href='?show=regards&order=0';\">";
$HeadTable.=  "  </td>";
$HeadTable.=  "  <td align='CENTER'>";
$HeadTable.=  "<b>�����</b>";
$HeadTable.=  "  </td>";         
$HeadTable.=  "  <td align='CENTER'>";
$HeadTable.=  "<b>&nbsp;</b>";
$HeadTable.=  "  </td>";
$HeadTable.=  " </tr>";
#��������� ������� ����������
if ($order=="0")
  $order= "ASC";
elseif ($order=="1")
  $order= "DESC";
$ordinal=0;
$result=mQuery("SELECT id,rdate, regard,name,firm,position FROM regards order by rdate $order");
print"<table border=\"1\">";
print "$HeadTable";

while ($row=mysql_fetch_array($result))
{

       $ordinal++;

       print " <tr>";
       print "<td>";
       print "$ordinal";
       print "</td>";
        #����;
       print "<td>";
       print "$row[1]";
       print "</td>";
      
       print "<td>";
       #�������������
       $regard=stripslashes($row[2]);
       $regard=substr($regard,0,$RegardLen)."...";
       $title="$row[3]";
       if ($row[4]!=="")
         $title.=" $row[4]";
       if ($row[5]!=="")
         $title.=" $row[5]";
       print"<a alt='$row[3]' href=\"?show=regards&action=view&id=$row[0]\" title=\"$title\">".$regard."</a>";
       print "</td>";    
       print "<td>";
       #��������
       print"<a href=\"?show=regards&action=del&id=$row[0]\" title=\"������� �����\" alt=\"������� �����\"><img src=\"../icons/delete.png\"></a>";
       print "</td>";
       print " </tr>";
}
print "</table>";
?>
