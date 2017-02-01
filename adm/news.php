<?php
if ($SystemMessage!='')
{
   print "<div class='quetion'>$SystemMessage</div><br>";
}
print "<a href='?show=news&action=add'>Добавить новость</a><br>";
print "<table border=1>";
#вывод шапки таблицы
print " <tr>";

print "  <td align='CENTER'>";
print "<b>№</b>";
print "  </td>";
print "  <td align='CENTER'>";
print "<b>Дата&nbsp;&nbsp;</b>";
print "<input type='BUTTON'  value='&nbsp;&uarr;&nbsp;' onclick=\"document.location.href='?show=news&order=1';\">&nbsp;";
print "<input type='BUTTON'  value='&nbsp;&darr;&nbsp;' onclick=\"document.location.href='?show=news&order=0';\">";

print "  </td>";
print "  <td align='CENTER'>";
print "<b>Заголовок</b>";
print "  </td>";
print "  <td align='CENTER'>";
print "<b>Ссылка</b>";
print "  </td>";
print "  <td align='CENTER'>";
print "<b>&nbsp;</b>";
print "  </td>";
print " </tr>";
#определяю порядок сортировки
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
   #номер по порядку
   print"$ordinal";
   print "</td>";
   #Дата
   print "<td>";
   print"<font size=2>$row[1]</font>";
   print "</td>";
   print "<td>";
   #наименовакние
   print"<a href=\"?show=news&action=edit&id=$row[0]\">".stripslashes($row[2])."</a>";
   print "</td>";
   print "<td>";
   #ссылка
   print"<font color='#0000FF'>?show=news&id=$row[0]&npage=1</font>";
   print "</td>";
   print "<td>";
   #удаление
   print"<a href=\"?show=news&action=del&id=$row[0]\"  title=\"Удалить новость\"><img src=\"../icons/delete.png\"></a>";
   print "</td>";
   print " </tr>";
}
print "</table>";
?>
