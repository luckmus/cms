<?php
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); 
header("Content-type: text/html; charset=windows-1251");
include "../../../messages/message.php";
include "../../../../libs/helpers.php";

$id = $_GET['id'];
$successFnc         = $_GET['successFnc'];
$successFncParam    = $_GET['successFncParam'];
$login = "login$id";
$pwd   = "pwd$id";
$msgText =  '
    <table border="0" width="330">    
        <tr>
            <td>
                Логин:
            </td>        
            <td>
                <input type="text" id="'.$login.'" name="'.$login.'" size="30"></input>
            </td>
        </tr>
        <tr>
            <td>
                Пароль:
            </td>        
            <td>
                <input type="password" id="'.$pwd.'" name="'.$pwd.'" size="30"></input>  
            </td>
        </tr>
        <tr>        
        
            <td>
            </td>        
            <td>
                <a href="#"  onclick="showAuthorisationFromLogin(\''.Message::processMsgId($id).'\',modalAuthPlace);">Регистрация</a>
            </td>
        </tr>        
    </table>
    ';
    $isXML = $_GET['isXML'];
    $js = $_GET['js'];      
    $title = "Авторизация";
    $msg = new Message($id,$title,$msgText,$successFnc,$successFncParam,"");
    $msg->setHeight(250);
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