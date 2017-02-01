<?php
    #BACKENR редактирование списка товаров

    include "../../libs/db.php";    
    include "../../libs/helpers.php";    
    include "../../config.php"; 
    include "../libs/vars.php";    
    include "../../libs/commonfunctions.php";     
    //include "../". _MODULES_EM_PATH ."parameter.php"; 
    include "../". _MODULES_EM_PATH ."em_promo.php"; 
    $dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
    mQuery("SET NAMES 'cp1251'", $dbh); 
    
    $mode = $_GET['mode'];
    if ($mode==""){
        $mode = $_POST['mode'];    
    }
    
    $name = $_GET['name'];
    if ($name==""){
        $name = $_POST['name'];    
    }
    $id = $_GET['id'];
    if ($id==""){
        $id = $_POST['id'];    
    }      
    $descr = $_GET['descr'];
    if ($descr==""){
        $descr = $_POST['descr'];    
    }    
    $value = $_GET['value'];
    if ($value==""){
        $value = $_POST['value'];    
    }    
    $date = $_GET['date'];
    if ($date==""){
        $date = $_POST['date'];    
    }    
    $name               = convertToWIN1251($name);
    $descr              = convertToWIN1251($descr); 
    $descr = html_entity_decode($descr);
    switch($mode){
        /*
        case 1:
            echo addGood($catId, $name);        
        break;
        case 2:
            echo delGood($id);        
        break;
        case 3:
            echo copyGood($id,$name);        
        break;
        */
        case 1:
            echo addPromo($name);      
        break;
        case 2:
            echo delPromo($id);        
        break;
        case 3:
            echo copyPromo($id,$name);        
        break;
        case 4:
            echo savePromo($id,$name, $descr, $value, $date);
        break;
    }
              
    
     function copyPromo($id,$name){
        $promo = new Promo($id); 
        $promo->name = $name;
        $promo->id=null;
        $promo->save();
        return 1;
     }
     
     function delPromo($id){
        $promo = new Promo($id); 
        $promo->remove();
        return 1;
     }
    
    function savePromo($id,$name, $descr, $value, $date){
        $promo = new Promo($id);
        $promo->name             = $name;
        $promo->descr             = $descr;
        $promo->value        = $value;
        $promo->endDate        = $date;  
        $promo->save();
        return 1;
    }
    
    function addPromo($name){
        $promo = new Promo(null);
        $promo->name             = $name;
        $promo->descr             = "";
        $promo->value        = 0;
        $promo->endDate        = date ("Y-m-d");  
        $promo->save();
        return 1;
    }
    
?>