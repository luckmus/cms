<?php
global $field,$ord;
require_once "../modules/em/usercommunication.php";
require_once "../modules/em/em_accounts.php";
if ($SystemMessage!='')
{
   print "<div class='quetion'>$SystemMessage</div><br>";
}
print "<b>Заказы</b><br>";
print "<table border=1>";
#вывод шапки таблицы
print " <tr>";
print "  <td align='CENTER'>";
print "<a href='?show=orders&ord=asc&field=7'>&uarr;</a>";
print "<a href='?show=orders&ord=desc&field=7'>&darr;</a>";
print "<b>№</b>";
print "  </td>";
print "  <td align='CENTER'>";
print "<a href='?show=orders&ord=asc&field=1'>&uarr;</a>";
print "<a href='?show=orders&ord=desc&field=1'>&darr;</a>";
print "<b>Наименование</b>";
print "  </td>";
print "  <td align='CENTER'>";
print "<a href='?show=orders&ord=asc&field=2'>&uarr;</a>";
print "<a href='?show=orders&ord=desc&field=2'>&darr;</a>";
print "<b>Дата заказа</b>";
print "  </td>";

print "  <td align='CENTER'>";
print "<a href='?show=orders&ord=asc&field=4'>&uarr;</a>";
print "<a href='?show=orders&ord=desc&field=4'>&darr;</a>";
print "<b>Пользователь</b>";
print "  </td>";

print "  <td align='CENTER'>";
print "<a href='?show=orders&ord=asc&field=4'>&uarr;</a>";
print "<a href='?show=orders&ord=desc&field=4'>&darr;</a>";
print "<b>ФИО</b>";
print "  </td>";

print "  <td align='CENTER'>";
print "<a href='?show=orders&ord=asc&field=5'>&uarr;</a>";
print "<a href='?show=orders&ord=desc&field=5'>&darr;</a>";
print "<b>Телефон</b>";
print "  </td>";

print "  <td align='CENTER'>";
print "<a href='?show=orders&ord=asc&field=6'>&uarr;</a>";
print "<a href='?show=orders&ord=desc&field=6'>&darr;</a>";
print "<b>email</b>";
print "  </td>";

print "  <td align='CENTER'>";
print "<a href='?show=orders&ord=asc&=3'>&uarr;</a>";
print "<a href='?show=orders&ord=desc&field=3'>&darr;</a>";
print "<b>Статус</b>";
print "  </td>";

print "  <td align='CENTER'>";
print "<b>&nbsp;</b>";
print "  </td>";
print " </tr>";

switch($field) 
{
    case 1:
        $orderField = "g.name";
    break;
    case 2:
        $orderField = "o.date";
    break;
    case 3:
        $orderField = "o.iscomlete";
    break;
    case 4:
        $orderField = "fio";
    break;
    case 5:
        $orderField = "o.tel";
    break;
    case 6:
        $orderField = "o.email";
    break;    
    case 7:
        $orderField = "o.id";
    break;
    default:
       $orderField = "o.id";
    break;
}
switch($ord ) 
{
    case 'asc':
        $orderType = "asc";
    break;
    case 'desc':
        $orderType = "desc";
    break;
    default:
       $orderType = "desc"; 
    break;    
} 
$result=mQuery("SELECT o.id,if(goodsId IS NOT null, (select name from em_goods where id =goodsId ) , \"Составной\"),o.date,o.iscomlete,o.datecomplete,CONCAT(o.firstname,' ',lastname) as FIO,tel,email, userId 
                FROM em_order o
                WHERE id_parent is null
                ORDER BY $orderField $orderType");
$ordinal=0;
while($row=mysql_fetch_array($result))
{
   $ordinal++;
   print " <tr>";
   #номер по порядку 
   print "<td>";
   //print "$ordinal";
   print "$row[0]";
   print "</td>";
   print "<td>";
   #наименование
   print"<a href='?show=orders&action=edit&id=$row[0]'>$row[1]</a>";
   print "</td>";
   print "<td>";
   #дата
   print"$row[2]";
   print "</td>";
   
   print "<td>";
   if (($row[8]!='')&&($row[8]!='0')){
     $account = new Account($row[8]);
     $account->load();
     $userName = "<a href=\"javascript:void(1)\" onClick=\"showAccountData($row[8]);\">".$account->login."</a>";
   }
   else{
       $userName = '&nbsp;';
   }
   #пользователь
   print"$userName";
   print "</td>";
   print "<td>";   
   #ФИО        
   print"$row[5]";
   print "</td>";
   print "<td>";
   #телефон
   print"$row[6]";
   print "</td>";
   print "<td>";
   #email
   print"<a href='mailto:$row[7]'>$row[7]</a>";
   print "</td>";         
   print "<td>";
   #статус
   if ($row[3]==1)
    $state = $row[4];
   else
    $state = 'не выполнен';
   print "$state";
   print "</td>";    
   print "<td>";
   print"<a href=\"?show=orders&action=del&id=$row[0]\"  alt=\"Удалить раздел\"><img src=\"../icons/delete.png\"></a>";
   print "</td>";
   print " </tr>";
}
print "</table>";
?>
