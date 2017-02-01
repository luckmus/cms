<?php
    header("Content-type: text/html; charset=windows-1251");
    include "../../../libs/commonfunctions.php";
    include "../../messages/message.php";
    $id                 = $_GET['id'];
    $title              = convertToWIN1251($_GET['title']);
    $msgText            = convertToWIN1251($_GET['msgText']);    
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