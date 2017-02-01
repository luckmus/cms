<?php
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); 
    header("Content-type: text/html; charset=windows-1251");
include "../../../messages/message.php";
include "../../../em/usercommunication.php";
include "../../../em/em_accounts.php";
include "../../../em/em_goods.php";
include "../../../em/em_cart.php";
include "../../../em/em_promo.php";
require_once "../../../../config.php";     
require_once "../../../../libs/db.php";     
require_once "../../../../libs/helpers.php";     
$dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
mQuery("SET NAMES 'cp1251'", $dbh);         
require_once "../../../../libs/init_settings_var.php";     

$firstname = strip_Tags($_POST['firstname']);
$lastname = strip_Tags($_POST['lastname']);
$tel = strip_Tags($_POST['tel']);
$email = strip_Tags($_POST['email']);
$adres = strip_Tags($_POST['adres']);
$descr = strip_Tags($_POST['descr']);
$fromCart = strip_Tags($_POST['fromCart']); 
$rcontrdig = $_POST['rcontrdig'];             
    $id = $_GET['id'];
    $userId = $_GET['userId'];
    $promo = strip_Tags($_GET['promo']);
    if ($userId==""){
        $userId = null;
    }
    else{
        //include "../../../../config.php"; 
        //include "../../../../libs/db.php";    
        include "../../../../libs/vars.php";    
        include "../../../../libs/commonfunctions.php"; 
        
        
        $account = new Account($userId);
        $account->load();
    }
    $successFnc         = $_GET['successFnc'];
    $successFncParam    = $_GET['successFncParam'];
    
    $msgText = "";
    $cart = new Cart();
    //$msgText .=displayCart();
    $msgText .= "<table boder=\"10\" cellpadding=\"0\" cellspacing=\"10\">";
    $descrCode = "<tr>";
    
    $descrCode .= "<td>";
    $descrCode .= "Сумма заказа:";
    $descrCode .= "</td>";
    
    $descrCode .= "<td>";
    $descrCode .= "<b>{$cart->getTotal()} {$GLOBALS[_CURRENCY]}</b>";
    $descrCode .= "</td>";
    
    $descrCode .= "</tr>";
    if (trim($promo)!=''){
        $promCode = Promo::getPromoByName($promo);
        if ($promCode!= null){
            $descrCode .= "<tr>";

            $descrCode .= "<td>";
            $descrCode .= "Скидка:";
            $descrCode .= "</td>";

            $descrCode .= "<td>";
            $descrCode .= "<b>{$promCode->value}%</b>";
            $descrCode .= "</td>";            
        }
    }
    $descrCode .= "<tr>";
    
    $descrCode .= "<td>";
    $descrCode .= "Примечание:";
    $descrCode .= "</td>";
    
    $descrCode .= "<td>";
    $descrCode .= "<textarea name=\"descr\" id=\"descrid$id\" class=\"address_elem\" rows=\"4\" cols=\"30\" >$descr</textarea>";
    $descrCode .= "</td>";
    
    $descrCode .= "</tr>";
    if ($userId==null){
    $msgText .= "<tr>";
    
    $msgText .= "<td>";
    $msgText .= "Имя:";
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    $msgText .= "<input id=\"firstnameid$id\" name=\"firstname\" value=\"$firstname\"  size=\"33\" class=\"inputtext\" type=\"text\"></input>";
    $msgText .= "</td>";
    
    $msgText .= "</tr>";
    
    $msgText .= "<tr>";
    
    $msgText .= "<td>";
    $msgText .= "Фамилия:";
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    $msgText .= "<input id=\"lastеnameid$id\" name=\"lastname\" value=\"$lastname\"  size=\"33\"  class=\"inputtext\" type=\"text\"></input>";
    $msgText .= "</td>";
    
    $msgText .= "</tr>";
    
    $msgText .= "<tr>";
    
    $msgText .= "<td>";
    $msgText .= "Телефон:<font color='red'>*</font>";
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    $msgText .= "<input id=\"telid$id\" name=\"tel\"  value=\"$tel\"  size=\"33\" class=\"inputtext\" type=\"text\"></input>";
    $msgText .= "</td>";
    
    $msgText .= "</tr>";
    
    $msgText .= "<tr>";
    
    $msgText .= "<td>";
    $msgText .= "e-mail:";
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    $msgText .= "<input id=\"emailid$id\" name=\"email\" value=\"$email\" size=\"33\" class=\"inputtext\" type=\"text\"></input>";
    $msgText .= "</td>";
    
    $msgText .= "</tr>";
    
    $msgText .= "<tr>";
    
    $msgText .= "<td>";
    $msgText .= "Адрес:";
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    $msgText .= "<textarea name=\"adres\" id=\"adresid$id\" class=\"address_elem\" rows=\"4\" cols=\"30\">$adres</textarea>";
    $msgText .= "</td>";
    
    $msgText .= "</tr>";
    
    $msgText .= $descrCode;    
    }//if ($userId==null)
    else{
        $msgText .= "<tr>";    
        $msgText .= "<td>Заказ пользователя</td>";    
        $msgText .= "<td><b>{$account->login}</b></td>";    
        $msgText .= "</tr>";    
        $msgText .= $descrCode;    
    }
    $msgText .= "<tr>";
    $msgText .= "<td>";
    $msgText .= "Контрольное число";    
    $msgText .= " <font color=\"red\">*</font><br></br><input type=\"text\" name=\"rcontrdig$id\" id=\"rcontrdig$id\" size=\"5\" maxlength=\"5\"></input>";
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    $cntrlDig = GetHost()."icons/ajax-loader.gif";
    $cntrldgId = "cntrldg$id";
    $msgText .= " <img src=\"$cntrlDig\" id=\"$cntrldgId\"></img><span onclick=\"refreshControlDig('$cntrldgId')\" style=\"cursor:pointer\">Обновить</span>";
    $msgText .= "</td>";
    
    $msgText .= "</tr>";
    $msgText .= "<tr>";
    
    $msgText .= "<td>";
    //$msgText .= "&nbsp;";
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    $msgText .= "</td>";
    
    $msgText .= "</tr>";
    $msgText .= "</table>";

    $isXML = $_GET['isXML'];
    $js = $_GET['js'];      
    $title = "Заказ товара";
    $msg = new Message($id,$title,$msgText,$successFnc,$successFncParam,"");
    $msg->setHeight(500);
    $msg->setWidth(400);
    $msg->setJS("refreshControlDig('$cntrldgId')");
    #если xml, то сформирую ее
    if ($isXML == 1){
        $xml = $msg->getMessageXML();
        echo $xml;
    }
    else{
        if ($js!=1){
            echo $msg->getHTML();
        }
        else
        {
            echo $msg->getJS();
        }
    }
function displayCart(){
    $res = '';
    $cart = findCartCookie();
    if ($cart==''){
        $res .= "empty cart";
    }
    else{
        $res .= "full cart ".$cart;
    }
        
    return $res;
} 

function findCartCookie(){
    foreach($_COOKIE as $cook){
        //return substr($cook, 0,5);
        if (substr($cook, 0,5) == 'cart_'){
            return substr($cook, 5);
        }
    }
    return "";
}
?>
