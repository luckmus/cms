<?php
    header("Content-type: text/html; charset=windows-1251");
    include "../../../libs/db.php";
    include "../../../config.php";     
    include "../../messages/message.php";
    include "../../em/parameter.php";
    include "../../../libs/commonfunctions.php";
    $dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
    mQuery("SET NAMES 'cp1251'", $dbh);
    $id                 = $_GET['id'];
    $title              = convertToWIN1251($_GET['title']);
    $successFnc         = $_GET['successFnc'];
    $successFncParam    = $_GET['successFncParam'];
    $goodId = $_GET['goodId'];
    $paramId = $_GET['paramId'];
    $act     = $_GET['act'];                    //0 - ��������� ����, 1- ��������������
    $param = new ParameterValues($paramId);
    $title = "������";
    switch($act){
        case 0:
        case 1:
            $msgText = "���������� �������� ��������� {$param->name} <br></br>";
            $values = $param->getElements();
            $msgText .= "<select id='param$goodId$paramId$id'>";
            
            for ($i=0; $i<count($values); $i++){
                $value = $values[$i];
                $msgText .="<option value='{$value->id}'>".$value->value."</option>";                
            }
            
            $msgText .= "</select>";
            if ($param->haveRelation()){
                $relParam = $param->relation;
               $msgText .= "<br></br>{$relParam->name }:<br></br>";
               $msgText .= "<input type='TEXT' value='' id='paramval$goodId$paramId$id'></input>";
            }
        break;        
        
    }
    $isXML = $_GET['isXML'];
    $js = $_GET['js'];  
    $msg = new Message($id,$title,$msgText,$successFnc,$successFncParam,"");
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