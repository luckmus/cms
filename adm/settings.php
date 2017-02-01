<?php
  print "<form method=\"POST\" id='mainSettFrom' onsubmit=\"document.getElementById('idsave').value='Сохранить';\">";
  print "<input type=\"HIDDEN\" name=\"action\" value=\"edit\">";
  print "<input type=\"HIDDEN\" name=\"show\" value=\"settings\">";
  print "<input type=\"HIDDEN\" id=\"idsave\" name=\"issave\" value=\"1\">";

echo "<table border=0>";
$res = mQuery("SELECT id,name, description,value FROM settings  Order by ordinal");
while ($row = mysql_fetch_row($res)){
    echo "<tr>";
    echo "<td>$row[2]:</td>";
    echo "<td><input type='TEXT' name='set_$row[0]' value='$row[3]'></td>";
    echo "</tr>";
    
}    
echo "</table>";
echo "<input type='BUTTON' value='Сохранить' onClick=\"document.getElementById('mainSettFrom').submit();\">";
  print "</form>";   
?>