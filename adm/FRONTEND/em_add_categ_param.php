<?php
    #скрипт отрисовывает диалог добавления параметра в категорию
    header("Content-type: text/html; charset=windows-1251");
    include "../../libs/db.php";
    include "../../config.php"; 
    include "../libs/vars.php";
    include "../../libs/helpers.php";
    include "../libs/helpers.php";
    include "../../libs/commonfunctions.php";  
    include "../". _MODULES_EM_PATH ."parameter.php"; 
    include "../". _MODULES_EM_PATH ."em_category.php";
    
    $dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
    //mQuery('SET character_set_database = cp1251');
    mQuery("SET NAMES 'cp1251'", $dbh);
        
    $id = $_GET['id'];
    $categ = new Category($id);
    $freeParams = $categ->getFreeParams();
    $selectVal = "<select id='paramid$id' style=\"width:200\">";
    for ($i=0; $i<count($freeParams); $i++){
        $p = $freeParams[$i];
         $selectVal .= "<option value='{$p->id}'>{$p->name}";
    }
    $selectVal .= "</select>";
    $content = '    <p class="validateTips" id="tipsid" >Добавление параметра категории</p>
    
    <form>
    <fieldset>
        <label for="name'.$id.'">Наименование</label>
        '.$selectVal.'

    </fieldset>
    </form>';
    
    echo $content;
                 
?>