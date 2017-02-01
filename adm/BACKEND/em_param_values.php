<?php
#BACKENR редактирование значений параметров

    include "../../libs/db.php";    
    include "../../config.php"; 
    include "../libs/vars.php";    
    include "../../libs/commonfunctions.php"; 
    include "../". _MODULES_EM_PATH ."parameter.php"; 
    
    
    $dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
    //mQuery('SET character_set_database = cp1251');
    mQuery("SET NAMES 'cp1251'", $dbh);   
    
    function add($pid, $value,$descr){
        $param = new ParameterValues($pid);
        $value = addslashes($value);
        $descr = addslashes($descr);
        $param->Add($value,$descr); 
        return 1;
    }
    function deletepv($id){
        $param = new ParameterValue($id);
        $param->Delete(); 
        return 1;
    }
    function edit($id,$value,$descr){
        $param = new ParameterValue($id);
        $value = addslashes($value);
        $descr = addslashes($descr);        
        $param->Edit($value,$descr);
        return 1;
    }    
    $mode   = $_GET['mode'];
    $pid    = $_GET['pid'];
    $id    = $_GET['id'];
    $value  = convertToWIN1251($_GET['value']);
    $descr  = convertToWIN1251($_GET['descr']);
    
    switch($mode){
        case "add":
            echo add($pid,$value,$descr);
        break;
        case "edit":
            echo edit($pid,$value,$descr);
        break;
        case "delete":
            echo deletepv($id);
        break;
    }

?>