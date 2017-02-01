<?php                                          
@session_start();
//include "libs/helpers.php";
//echo "issaveE=$issave<br>";

$firstname = strip_Tags($_POST['firstname']);
$lastname = strip_Tags($_POST['lastname']);
$tel = strip_Tags($_POST['tel']);
$email = strip_Tags($_POST['email']);
$adres = strip_Tags($_POST['adres']);
$descr = strip_Tags($_POST['descr']);
$rcontrdig = $_POST['rcontrdig'];
//$issave = $_POST['issave'];
                       
if ($issave==1)
{       
    $ErrMes = checkOrderForm();
    if ($ErrMes != '')         
    {
        $issave = 2;                              
        $isOrderSave = 2;                              
  //      echo "error issave=$issave";
        return;   
    }    
}           
if ( $issave != 1)
{
    print "<div align = \"CENTER\"><b><i>Форма заказа товара</i></b></div>";  
    if ( $issave == 2)  $ErrMes = checkOrderForm();
    print "<font color='RED'>$ErrMes</font>"; 
    print "<form method='POST'"; 
    print "<input type = 'HIDDEN' name = 'show' value = '$show'>";
    print "<input type = 'HIDDEN' name = 'id' value = '$id'>";
    print "<input type = 'HIDDEN' name = 'issave' id='issaveid' value = '0'>";
    print "<table boder=0 cellpadding=\"0\" cellspacing=\"10\">";
    print "<tr>";
    print "<td>";
    print "Имя:";
    print "</td>";
    print "<td>";
    print "<input id=\"firstnameid\" name=\"firstname\" value=\"$firstname\"  class=\"inputtext\" type=\"text\">";
    print "</td>";
    print "</tr>";
    print "<tr>";
    print "<td>";
    print "Фамилия:";
    print "</td>";
    print "<td>";
    print "<input id=\"lastеnameid\" name=\"lastname\" value=\"$lastname\"  class=\"inputtext\" type=\"text\">";
    print "</td>";
    print "</tr>";
    print "<tr>";
    print "<td>";
    print "Телефон:";
    print "</td>";
    print "<td>";
    print "<input id=\"telid\" name=\"tel\"  value=\"$tel\" class=\"inputtext\" type=\"text\">";
    print "</td>";
    print "</tr>";
    print "<tr>";
    print "<td>";
    print "e-mail:";
    print "</td>";
    print "<td>";
    print "<input id=\"emailid\" name=\"email\" value=\"$email\"  class=\"inputtext\" type=\"text\">";
    print "</td>";
    print "</tr>";
    print "<tr>";
    print "<td>";
    print "Адрес:";
    print "</td>";
    print "<td>";
    print "<textarea name=\"adres\" class=\"address_elem\" rows=\"4\">$adres</textarea>";
    print "</td>";
    print "</tr>";
    print "</tr>";
    print "<tr>";
    print "<td>";
    print "Примечание:";
    print "</td>";
    print "<td>";
    print "<textarea name=\"descr\" class=\"address_elem\" rows=\"4\">$descr</textarea>";
    print "</td>";
    print "</tr>";
    print "<tr>";
    print "<td>";
    print "Контрольное число";
    
    print " <font color='red'>*</font><br><input type='text' name='rcontrdig' size=5 maxlength=5>";
    print "</td>";
    print "<td>";
    print " <img src='controldig.php'><a onclick='document.forms[1].submit();' style='cursor:hand'>Обновить</a>";
    print "</td>";
    print "</tr>";
    print "<tr>";
    print "<td>";
    print "&nbsp;";
    print "</td>";
    print "<td>";
    print "<input class=\"checkout_buttons\" value=\"Заказать\" type=\"submit\" onClick=\"document.getElementById('issaveid').value=1;\" />";
    print "</td>";
    print "</tr>";
    print "</table>";


    print "</form>";
}
else
if ( $issave == 1)
#добавление заказа
{
    $firstname = addslashes($firstname);
    $lastname = addslashes($lastname);
    $tel = addslashes($tel);
    $email = addslashes($email);
    $adres = addslashes($adres);
    $descr = addslashes($descr);
    $res = mQuery("INSERT INTO em_order(goodsId,firstname,lastname,tel,email,adres,description)
                   values($id, '$firstname','$lastname','$tel','$email','$adres','$descr');");
    $_SESSION['infomessgae'] = "</b>Заказ принят. <br>В ближайшее время с Вами свяжется наш менеджер.</b>";
    $issave = 0;
    header("Location:?show=message&mesid=ordersuccessfully");
                
}
    
?>