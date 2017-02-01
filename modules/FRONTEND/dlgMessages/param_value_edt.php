<?php
    header("Content-type: text/html; charset=windows-1251");
    include "../../../libs/db.php";
    include "../../../config.php";     
    include "../../messages/message.php";
    include "../../em/parameter.php";
    include "../../../libs/commonfunctions.php";
    $dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
    mQuery("SET NAMES 'cp1251'", $dbh);
    $pid                 = $_GET['pid'];
    $id                  = $_GET['id'];
    $paramValId                  = $_GET['paramValId'];
    $mode                 = $_GET['mode'];
    $title              = convertToWIN1251($_GET['title']);
    $successFnc         = $_GET['successFnc'];
    $successFncParam    = $_GET['successFncParam'];
    $catId = $_GET['catId'];
    $title = "Товары";

    switch ($mode){
        //добавление
        case 0:
            $param = new ParameterValues($pid);
            $params = $param->getElements();
            $title = $param->name;
            $caption = "Добавление нового значения \"{$param->name}\"";
            $value  ="";
            $descr  ="";
        break;
        case 1:
            $paramValue = new ParameterValue($paramValId);            
            $param = new ParameterValues($paramValue->pid);
            $params = $param->getElements();  
            $caption = "Редактирование значения \"{$param->name}\"";
            $value  =$paramValue->value;
            $descr  =$paramValue->descr;        
        break;    

    }
$msgText=
            '    <p class="validateTips" id="tipsid" >'.$caption.'</p>

    <fieldset>
        <label for="name'.$id.'">Наименование</label>
        <input type="text" name="name'.$id.'" id="name'.$id.'" class="text ui-widget-content ui-corner-all" value="'.$value.'" />
        <label for="descr'.$id.'">Описание</label>
        <textarea id="descr'.$id.'" cols="45" rows="4">'.$descr.'</textarea>
    </fieldset>';
    $isXML = $_GET['isXML'];
    $js = $_GET['js'];  
    $msg = new Message($id,$title,$msgText,$successFnc,$successFncParam,"");
    $msg->setHeight(350);
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