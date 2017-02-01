<?php
    #BACKENR редактирование значений параметров  характеристик категорий  товаров
    header("Content-type: text/html; charset=windows-1251");
    include "../../libs/db.php";    
    include "../../config.php"; 
    include "../libs/vars.php";    
    include "../../libs/commonfunctions.php"; 
    include "../../libs/helpers.php"; 
    include "../". _MODULES_EM_PATH ."parameter.php"; 
    include "../". _MODULES_EM_PATH ."em_category.php"; 
    $dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
    //mQuery('SET character_set_database = cp1251');
    mQuery("SET NAMES 'cp1251'", $dbh);     
    $id     = $_GET['id'];
    $pid     = $_GET['pid'];
    $name   = convertToWIN1251($_GET['name']);
    $descr  = convertToWIN1251($_GET['descr']);
    $img    = convertToWIN1251($_GET['img']);
    $mode    = $_GET['mode'];

    function Edit($id,$name,$descr,$img){
        $categ = new Category($id);
        $categ->updCategory($name,$descr,$img);
        return 1;
    }    
    
    function Add($name,$descr,$img){
        $categs = new Categoryes();
        $categs->add($name,$descr,$img);
        return 1;
    }    
    function Del($id){
        $categs = new Categoryes();
        return $categs->delete($id);
    }
    function AddParam($id,$pid){
        $categ =  new Category($id);
        $categ->addParam($pid);
        return 1;
    } 
    function DelParam($cid,$pid){
        $categ =  new Category($cid);
        $categ->delParam($pid);
        return 1;
    } 
    function downParam($cid,$pid){
        $categ =  new Category($cid);
        return $categ->downParam($pid);
    } 
    function upParam($cid,$pid){
        $categ =  new Category($cid);
        return $categ->upParam($pid);
    }    
    
    switch ($mode){
        case "edit":
            echo Edit($id,$name,$descr,$img);
        break;
        case "add":
            echo Add($name,$descr,$img);
        break;
        case "del":
            echo Del($id);
        break;   
        
        case "addparam":
            echo AddParam($id,$pid);
        break;  
        case "delparam":
            echo DelParam($id,$pid);
        break; 
        case "downparam":
            echo downParam($id,$pid);
        break; 
        case "upparam":
            echo upParam($id,$pid);
        break;   
        
    }
?>