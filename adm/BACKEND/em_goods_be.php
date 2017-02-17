<?php
    #BACKENR редактирование списка товаров

    include "../../libs/db.php";    
    include "../../libs/helpers.php";    
    include "../../config.php"; 
    include "../libs/vars.php";    
    include "../../libs/commonfunctions.php";     
    //include "../". _MODULES_EM_PATH ."parameter.php"; 
    include "../". _MODULES_EM_PATH ."em_goods.php"; 
    include "../". _MODULES_EM_PATH ."parameter.php"; 
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
    
    $catId = $_GET['catId'];
    if ($catId==""){
        $catId = $_POST['catId'];    
    } 
    $id = $_GET['id'];
    if ($id==""){
        $id = $_POST['id'];    
    }   

    $goodId = $_GET['goodId'];
    if ($goodId==""){
        $goodId = $_POST['goodId'];    
    }    
    $descr = $_GET['descr'];
    if ($descr==""){
        $descr = $_POST['descr'];    
    }    
    $imageFile = $_GET['imageFile'];
    if ($imageFile==""){
        $imageFile = $_POST['imageFile'];    
    }    
    $metaDescription = $_GET['metaDescription'];
    if ($metaDescription==""){
        $metaDescription = $_POST['metaDescription'];    
    }   
    $metakeywords = $_GET['metakeywords'];
    if ($metakeywords==""){
        $metakeywords = $_POST['metakeywords'];    
    }
    
    $photo = $_GET['photo'];
    if ($photo==""){
        $photo = $_POST['photo'];    
    }   
    
    $name               = convertToWIN1251($name);
    $metaDescription    = convertToWIN1251($metaDescription); 
    $metakeywords       = convertToWIN1251($metakeywords); 
    $descr              = convertToWIN1251($descr); 
    $descr = html_entity_decode($descr);
    switch($mode){
        case 1:
            echo addGood($catId, $name);        
        break;
        case 2:
            echo delGood($id);        
        break;
        case 3:
            echo copyGood($id,$name);        
        break;
        case 4:
            echo saveGood($goodId, $catId, $name, $descr, $imageFile, $metaDescription, $metakeywords);
        break;
        case 5:
            echo archGood($id);        
        break; 
        case 6:
            echo unArchGood($id);        
        break;        
        case 7:
            echo addGalleryPhoto($goodId, $photo, $descr);        
        break;  
    }
    
    function addGalleryPhoto($goodsId, $photo, $descr){
        //echo "не реализовано $goodsId, $photo, $descr";
         $gp = new GoodsPhoto(null, $goodsId, $photo, null, $descr);
         $gp->save();
         return 1;
    }
    function addGood($catId, $name){
        $goodsLost = new GoodsList();
        $goodsLost->LoadAll();
        $goodsLost->add($catId, $name);
        return 1;
    }
    
    function delGood($id){
        $goodsLost = new GoodsList();
        $goodsLost->LoadAll();
        $goodsLost->delete($id);
        return 1;
    }
    
    function copyGood($id,$newName){
        $goodsList = new GoodsList();
        $goodsList->LoadAll();
        return $goodsList->copyGoodsOne($id,$newName);
    }
    
    function saveGood($goodId, $catId, $name, $descr, $imageFile, $metaDescription, $metakeywords){
        $goodsOne = new Goods($goodId);
        $goodsOne->categoryid       = $catId;
        $goodsOne->name             = $name;
        $goodsOne->desc             = $descr;
        $goodsOne->imagefile        = $imageFile;
        $goodsOne->metadescription  = $metaDescription;
        $goodsOne->metakeywords     = $metakeywords;
        $goodsOne->save();
        return 1;
    }
    function archGood($id){
        $goodsOne = new Goods($id);
        $goodsOne->Load();
        return $goodsOne->archivate();
    }
    function unArchGood($id){
        $goodsOne = new Goods($id);
        $goodsOne->Load();
        return $goodsOne->unArchivate();
    }    
?>