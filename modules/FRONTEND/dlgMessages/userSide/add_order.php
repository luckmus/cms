<?php
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); 
    header("Content-type: text/html; charset=windows-1251");
include "../../../messages/message.php";
include "../../../em/usercommunication.php";
include "../../../em/em_accounts.php";
include "../../../../libs/helpers.php";   
    $firstname = strip_Tags($_POST['firstname']);
$lastname = strip_Tags($_POST['lastname']);
$tel = strip_Tags($_POST['tel']);
$email = strip_Tags($_POST['email']);
$adres = strip_Tags($_POST['adres']);
$descr = strip_Tags($_POST['descr']);
$rcontrdig = $_POST['rcontrdig'];
    $id = $_GET['id'];
    $userId = $_GET['userId'];
    if ($userId==""){
        $userId = null;
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
    $descrCode = "<tr>";
    
    $descrCode .= "<td>";
    $descrCode .= "����������:";
    $descrCode .= "</td>";
    
    $descrCode .= "<td>";
    $descrCode .= "<textarea name=\"descr\" id=\"descrid$id\" class=\"address_elem\" rows=\"4\" cols=\"30\" >$descr</textarea>";
    $descrCode .= "</td>";
    
    $descrCode .= "</tr>";
    if ($userId==null){
    $msgText .= "<tr>";
    
    $msgText .= "<td>";
    $msgText .= "���:";
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    $msgText .= "<input id=\"firstnameid$id\" name=\"firstname\" value=\"$firstname\"  size=\"33\" class=\"inputtext\" type=\"text\"></input>";
    $msgText .= "</td>";
    
    $msgText .= "</tr>";
    
    $msgText .= "<tr>";
    
    $msgText .= "<td>";
    $msgText .= "�������:";
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    $msgText .= "<input id=\"last�nameid$id\" name=\"lastname\" value=\"$lastname\"  size=\"33\"  class=\"inputtext\" type=\"text\"></input>";
    $msgText .= "</td>";
    
    $msgText .= "</tr>";
    
    $msgText .= "<tr>";
    
    $msgText .= "<td>";
    $msgText .= "�������:<font color='red'>*</font>";
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
    $msgText .= "�����:";
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    $msgText .= "<textarea name=\"adres\" id=\"adresid$id\" class=\"address_elem\" rows=\"4\" cols=\"30\">$adres</textarea>";
    $msgText .= "</td>";
    
    $msgText .= "</tr>";
    
    $msgText .= $descrCode;    
    }//if ($userId==null)
    else{
        $msgText .= "<tr>";    
        $msgText .= "<td>����� ������������</td>";    
        $msgText .= "<td><b>{$account->login}</b></td>";    
        $msgText .= "</tr>";    
        $msgText .= $descrCode;    
    }
    $msgText .= "<tr>";
    $msgText .= "<td>";
    $msgText .= "����������� �����";    
    $msgText .= " <font color=\"red\">*</font><br></br><input type=\"text\" name=\"rcontrdig$id\" id=\"rcontrdig$id\" size=\"5\" maxlength=\"5\"></input>";
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    $cntrlDig = GetHost()."icons/ajax-loader.gif";
    $cntrldgId = "cntrldg$id";
    $msgText .= " <img src=\"$cntrlDig\" id=\"$cntrldgId\"></img><span onclick=\"refreshControlDig('$cntrldgId')\" style=\"cursor:pointer\">��������</span>";
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
    $title = "����� ������";
    $msg = new Message($id,$title,$msgText,$successFnc,$successFncParam,"");
    $msg->setHeight(500);
    $msg->setWidth(400);
    $msg->setJS("refreshControlDig('$cntrldgId')");
    #���� xml, �� ��������� ��
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
