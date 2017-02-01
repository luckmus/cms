<?php

    global $dbh;      
    //header("Content-type: text/html; charset=windows-1251");
    if (!isset($dbh)){
        $isAJAX = true;
        //$isAJAX = false;
        header("Content-type: text/html; charset=windows-1251");
        require_once "libs/vars.php";    
        include "../libs/db.php";
        include "../config.php"; 
        //include "libs/vars.php";
        include "../libs/helpers.php";
        include  _MODULES_EM_PATH ."parameter.php";
        include  _MODULES_EM_PATH ."em_category.php";
        include  _MODULES_EM_PATH ."em_goods.php";
        require_once  _MODULES_EM_PATH ."em_promo.php";
        $dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
        mQuery("SET NAMES 'cp1251'", $dbh);                
        echo '{ "content": "';    
    }
    else    
    {
        $isAJAX = false;
        include  _MODULES_EM_PATH ."em_goods.php";
    }
    $allPromo = new PromoList();
    
    $paramFace = getHost()._ADM_FRONTEND."em_promo_fe.php";     
    echo "<div id='"._MAIN_PROMO_CONT."'>";
    echo "<ul>";     
    for($i=0; $i<count($allPromo->list); $i++){
        $promo = $allPromo->list[$i];    
        $paramUrl = $paramFace."?id=".$promo->id;    
        echo "<li><a href='$paramUrl'><span>{$promo->name}  </span></a></li>"; 
    }
    echo "</ul>";
    echo "</div>";
    $jsScript = "\$('#"._MAIN_PROMO_CONT."').tabs().addClass('ui-tabs-vertical ui-helper-clearfix');\$('#"._MAIN_PROMO_CONT." li').removeClass('ui-corner-top').addClass('ui-corner-left');";        

    if ($isAJAX){
        echo '", ';
        echo "\"js\": \"$jsScript\"}";  
    }
    else{
        echo "<script>$jsScript</script>";    
    }

//echo "<script>$jsScript</script>";
    return;    
  
?>