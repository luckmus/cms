<?php
    header("Content-type: text/html; charset=windows-1251");
    include "../../messages/message.php";
    include "../../../libs/commonfunctions.php";
    $id                 = $_GET['id'];
    $title              = convertToWIN1251($_GET['title']);
    $msgText            = convertToWIN1251($_GET['msgText']);
    /*
    $title = htmlspecialchars(urldecode($title));
    $title = iconv('UTF-8', 'windows-1251', $title);    
    if($title=="")$title = $_GET['title'];
      
    $msgText = htmlspecialchars(urldecode($msgText));
    $msgText = iconv('UTF-8', 'windows-1251', $msgText);    
    if($msgText=="")$msgText = $_GET['msgText'];
     */ 
    $successFnc         = $_GET['successFnc'];
    $successFncParam    = $_GET['successFncParam'];
    $isXML = $_GET['isXML'];
    $js = $_GET['js'];
    $msg = new Message($id,$title,$msgText,$successFnc,$successFncParam,"");
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