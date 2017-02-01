<?php
    #BACKENR редактирование значений параметров   товаров

    include "../../libs/db.php";    
    include "../../config.php"; 
    include "../libs/vars.php";    
    include "../../libs/commonfunctions.php"; 
    include "../". _MODULES_EM_PATH ."parameter.php"; 
    include "../". _MODULES_EM_PATH ."em_goods.php"; 
    $dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
    //mQuery('SET character_set_database = cp1251');
    mQuery("SET NAMES 'cp1251'", $dbh); 
    
    $id = $_GET['id'];
    $valueiId = $_GET['valueId'];
    $paramId = $_GET['paramId'];
    $value = $_GET['value'];
    $mode = $_GET['mode'];
    switch($mode){
        //установить новое значение
        case 0:   
             addParam($id, $valueiId, $value);
             echo 1;
        break;
        //редактироваит удже установленное значение
        case 1:   
           updParam($id,$valueiId,$value);
        break;
        //удаляет значение
        case 2:   
           delParam($id,$valueiId,$paramId);
        break;
    }
    function addParam($goodId, $pvId, $value){
        $goodsOne = new Goods($goodId);
        $lastId = $goodsOne->addParam($pvId, $value);
        //если $value !=null значит есть зависимый параметр, его надо создать и задать ему значение
        if ($value!=''){
            $newGoodsParam = new GoodsParameter($lastId);
            $newGoodsParam->UpdateValue($value);
        }        
    }
    
    function updParam($GoodsParameterId, $valueiId,$value){
        $gp = new GoodsParameter($GoodsParameterId);
        $gp->Update($valueiId);
        $gp->UpdateValue($value);

        echo 1;
        
    }
    function delParam($goodId, $gpId,$paramId){
        $goodsOne = new Goods($goodId);
        $goodsOne->getGoodsParam($paramId);
        echo $goodsOne->DeleteParam($gpId);        
    }    
?>