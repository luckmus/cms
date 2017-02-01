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
        $dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
        mQuery("SET NAMES 'cp1251'", $dbh);                
        echo '{ "content": "';    
    }
    else{        
        $isAJAX = false;
        include _MODULES_EM_PATH."parameter.php";
        include _MODULES_EM_PATH."em_category.php";
    }
    
    $categList = new Categoryes();
    $paramFace = GetHost()._ADM_FRONTEND."em_category_params.php";
    echo "<div id='"._MAIN_CATEG_CONT."'>";
    echo "<ul>";              
    for ($i = 0; $i<count($categList->catArray); $i++){        
        $cat = $categList->catArray[$i];
        $cat->Load();        
        $paramUrl = $paramFace."?id=".$cat->id; 
        echo "<li><a href='$paramUrl'><span>{$cat->name}  </span></a></li>";        
    }
    echo "</ul>";
    echo "</div>";    
    $jsScript = "\$('#"._MAIN_CATEG_CONT."').tabs().addClass('ui-tabs-vertical ui-helper-clearfix');\$('#"._MAIN_CATEG_CONT." li').removeClass('ui-corner-top').addClass('ui-corner-left');";
    if ($isAJAX){
        echo "\",";
        echo "\"js\":\"$jsScript\"}";  
    }
    else{
        echo "<script>$jsScript</script>";    
    }
?>