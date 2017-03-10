<?php
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); 
include "../../../messages/message.php";
include "../../../em/usercommunication.php";
include "../../../em/em_accounts.php";
include "../../../../libs/helpers.php";

//$goodsId = $_GET['goodsid'];
//$goodsPrice = $_GET['goodsprice'];
 
    header("Content-type: text/html; charset=windows-1251");
/*    
    $firstname = strip_Tags($_POST['firstname']);
$lastname = strip_Tags($_POST['lastname']);
$tel = strip_Tags($_POST['tel']);
$email = strip_Tags($_POST['email']);
$adres = strip_Tags($_POST['adres']);
$descr = strip_Tags($_POST['descr']);
$rcontrdig = $_POST['rcontrdig'];
*/
    $id = $_GET['id'];
    $userId = addslashes($_GET['userId']);
    if ($userId==""){
        $userId = null;
        $account = new Account($userId);
    }
    else{                               
        include "../../../../config.php"; 
        include "../../../../libs/db.php";    
        include "../../../../libs/vars.php";    
        include "../../../../libs/commonfunctions.php"; 
        
        $dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
        mQuery("SET NAMES 'cp1251'", $dbh);     
        $account = new Account($userId);
        $account->load();        
    }


    $successFnc         = $_GET['successFnc'];
    $successFncParam    = $_GET['successFncParam'];
    
    $msgText = "";
    $msgText .= "<table boder=\"10\" cellpadding=\"0\" cellspacing=\"10\">";
    $msgText .= "<tr>";
    
    $msgText .= "<td>";
    $msgText .= "Логин:<font color=\"red\">*</font>";
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    if($userId==null){
        $msgText .= "<input id=\"loginid$id\" name=\"login\" value=\"\"  size=\"33\" class=\"inputtext\" type=\"text\"></input>";
    }
    else{
        $msgText .= $account->login;
    }
    $msgText .= "</td>";
    
    $msgText .= "</tr>";
    if($userId==null){
        $f_pwd_lbl = "Пароль:";
        $s_pwd_lbl = "Повтор пароля:";
    }
    else{
        $f_pwd_lbl = "Новый пароль:";
        $s_pwd_lbl = "Повтор нового пароля:";    
            
        $msgText .= "<tr>";    
        $msgText .= "<td>";
        $msgText .= "Старый пароль:<font color=\"red\">*</font>";
        $msgText .= "</td>";
    
        $msgText .= "<td>";
        $msgText .= "<input id=\"oldpwdid$id\" name=\"oldpwd\" value=\"$firstname\"  size=\"33\" class=\"inputtext\" type=\"password\"></input>";
        $msgText .= "</td>";
    
        $msgText .= "</tr>";         
    }
        $msgText .= "<tr>";    
        $msgText .= "<td>";
        $msgText .= "$f_pwd_lbl<font color=\"red\">*</font>";
        $msgText .= "</td>";
    
        $msgText .= "<td>";
        $msgText .= "<input id=\"pwdid$id\" name=\"pwd\" value=\"$firstname\"  size=\"33\" class=\"inputtext\" type=\"password\"></input>";
        $msgText .= "</td>";
    
        $msgText .= "</tr>";    
        $msgText .= "<tr>";
    
        $msgText .= "<td>";
        $msgText .= "$s_pwd_lbl<font color=\"red\">*</font>";
        $msgText .= "</td>";
        
        $msgText .= "<td>";
        $msgText .= "<input id=\"repwdid$id\" name=\"repwd\" value=\"$firstname\"  size=\"33\" class=\"inputtext\" type=\"password\"></input>";
        $msgText .= "</td>";
    
        $msgText .= "</tr>";     
     $msgText .= "<tr>";
    
    $msgText .= "<td>";            
    $msgText .= "Имя:<font color=\"red\">*</font>";
        
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    $msgText .= "<input id=\"lastеnameid$id\" name=\"lastname\" value=\"{$account->lastname}\"  size=\"33\" class=\"inputtext\" type=\"text\"></input>";    
    $msgText .= "</td>";
    
    $msgText .= "</tr>";
    
    $msgText .= "<tr>";
    
    $msgText .= "<td>";
    $msgText .= "Фамилия:";
    $msgText .= "</td>";
    
    $msgText .= "<td>";       
    $msgText .= "<input id=\"firstnameid$id\" name=\"firstname\" value=\"{$account->firstName}\"  size=\"33\"  class=\"inputtext\" type=\"text\"></input>";
    $msgText .= "</td>";
    
    $msgText .= "</tr>";
    
    $msgText .= "<tr>";
    
    $msgText .= "<td>";
    $msgText .= "Телефон:<font color=\"red\">*</font>";
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    $msgText .= "<input id=\"telid$id\" name=\"tel\"  value=\"{$account->tel}\"  size=\"33\" class=\"inputtext\" type=\"text\"></input>";
    $msgText .= "</td>";
    
    $msgText .= "</tr>";
    
    $msgText .= "<tr>";
    
    $msgText .= "<td>";
    $msgText .= "e-mail:<font color=\"red\">*</font>";
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    $msgText .= "<input id=\"emailid$id\" name=\"email\" value=\"{$account->email}\" size=\"33\" class=\"inputtext\" type=\"text\"></input>";
    $msgText .= "</td>";
    
    $msgText .= "</tr>";
    
    $msgText .= "<tr>";
    
    $msgText .= "<td>";
    $msgText .= "Адрес:";
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    $msgText .= "<textarea name=\"adres\" id=\"adresid$id\" class=\"address_elem\" rows=\"4\" cols=\"30\">{$account->adres}</textarea>";
    $msgText .= "</td>";
    
    $msgText .= "</tr>";
    
    
    $msgText .= "<tr>";
    $msgText .= "<td>";
    $msgText .= "Контрольное число";    
    $msgText .= " <font color='red'>*</font><br></br><input type=\"text\" name=\"rcontrdig$id\" id=\"rcontrdig$id\" size=\"4\" maxlength=\"4\"></input>";
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
    $title = "Регистрационные данные";
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
    
?>
