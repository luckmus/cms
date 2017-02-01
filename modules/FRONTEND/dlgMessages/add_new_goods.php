<?php
    header("Content-type: text/html; charset=windows-1251");
    include "../../../config.php";
    include "../../../libs/db.php";
    include "../../messages/message.php";
    include "../../em/parameter.php"; 
    include "../../em/em_category.php";    
    include "../../../libs/commonfunctions.php";

    $dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
    mQuery("SET NAMES 'cp1251'", $dbh);    
    $tabId                 = $_GET['tabId'];
    $id                 = $_GET['id'];
    $mode                 = $_GET['mode'];
    $goodId                 = $_GET['goodId'];

    //$successFnc         = $_GET['successFnc'];
    //$successFncParam    = $_GET['successFncParam'];
    $isXML = $_GET['isXML'];
    $js = $_GET['js'];
    $randId = (rand(1,10000)*1000);
    switch($mode){
        case 1:
            $title = 'Добавление нового товара';
            $nameValCont =  'new-good-name'.$randId;
            $catValCont =  'new-good-category'.$randId;
            $msgText = '<label for="'.$catValCont.'">Категория</label>';
            $msgText .=  "<select id = \"$catValCont\">";
            $categs = new Categoryes();
  
            $allCats = $categs->catArray;
            for($i = 0; $i<count($allCats); $i++){
                $cat =  $allCats[$i];   
                $cat->Load();
                $msgText .= "<option value=\"{$cat->id}\">{$cat->name}</option>";
            }
            $msgText .= "</select><br></br>";
      
            $msgText .= 
        '<label for="'.$nameValCont.'">Наименование</label>          
        <input type="text" id="'.$nameValCont.'"  class="text ui-widget-content ui-corner-all" />';
            $successFnc = 'addGoodsBE';    
            $successFncParam = "'$nameValCont','$catValCont','$tabId'";
      break;
        case 2:
            $title = 'Копирование товара';
            $nameValCont =  'new-good-name'.$randId;
      
            $msgText .= 
        '<label for="'.$nameValCont.'">Новое наименование</label>          
        <input type="text" id="'.$nameValCont.'"  class="text ui-widget-content ui-corner-all" />';
            $successFnc = 'copyGoodsBE';    
            $successFncParam = "$goodId, '$nameValCont','$tabId'";
      break;
    }//switch
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