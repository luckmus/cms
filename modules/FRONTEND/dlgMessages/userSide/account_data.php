<?php
   header("Content-type: text/html; charset=windows-1251");
   include "../../../messages/message.php";
   include "../../../em/usercommunication.php";
   include "../../../em/em_accounts.php";
   include "../../skin/common_skin/cabinet_viewer.php";
   include "../../../../libs/helpers.php";
   include "../../../../config.php"; 
   include "../../../../libs/db.php";    
   include "../../../../libs/vars.php";    
   include "../../../../libs/commonfunctions.php"; 
        
   $dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
   mQuery("SET NAMES 'cp1251'", $dbh);          
   $userId = $_GET['userId'];
   $acc_view = new CabinetViewer($userId);
   $res = $acc_view->getAccountAbout();
   
   
    
    $id                 = $_GET['id'];
    $title              = convertToWIN1251($_GET['title']);
    $msgText            = $res;    
    $isXML = $_GET['isXML'];
    $msg = new Message($id,$title,$msgText,$successFnc,$successFncParam,"");
    $msg->setIsAlert();
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