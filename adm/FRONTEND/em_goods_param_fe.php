<?php
#отображает вкладку параметров конкретного товара
    header("Content-type: text/html; charset=windows-1251");
    require_once "../libs/vars.php";    
    include "../../libs/db.php";
    include "../../config.php"; 
    //include "libs/vars.php";
     include "../../libs/helpers.php";
     include "../../libs/commonfunctions.php";
     include "../libs/helpers.php";                    
    include  "../"._MODULES_EM_PATH ."parameter.php";
    include  "../"._MODULES_EM_PATH ."em_category.php";
    include  "../"._MODULES_EM_PATH ."em_goods.php";
    include  "../"._MODULES_MSG_PATH ."message.php";
    $dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
    mQuery("SET NAMES 'cp1251'", $dbh);
    
    $goodId = $_GET['goodId'];
    $paramId = $_GET['paramId'];  
    //слой дл€ отображени€ сообщений
    echo "<div id='"._GOODS_PARAM_EDT_MSG."$goodId$paramId'></div>";
    
    echo "<div>";    
    $goodsOne = new Goods($goodId);
    $goodsParamArr = $goodsOne->getGoodsParam($paramId);
    if ($goodsParamArr==null){
        $value = "<a href=# onClick=\"setGoodsParamValFE(0, $goodId, $paramId,'"._GOODS_PARAM_EDT_MSG."$goodId$paramId','"._GOODS_PARAM_CONT."$goodId');\">установить";
    }
    else{
        $value = "<table border = 0 width=250>";
            //проверю наличие зависимостей у даного параметра
        $PatentParam = new ParameterValues($paramId);
        
        {
            //выведу заголовок таблицы
           $value .="<tr>
                    <td><b>{$PatentParam->name}</b></td>
                    <td><b>{$PatentParam->relation->name}</b></td> 
                    <td></td>
                  </tr>";     
        }        
        for($i=0; $i<count($goodsParamArr); $i++){
            $gp = $goodsParamArr[$i][0];
            $p=$gp->parameter;
 
            $host = getHost();
            $value .= "<tr><td>{$p->value}</td>
                        <td>{$goodsParamArr[$i][1]}</td><td>
            <a href=# title='»зменить' 
                onClick=\"EdtGoodsParamValFE(1, $goodId, $paramId,{$gp->id},'"._GOODS_PARAM_EDT_MSG."$goodId$paramId','"._GOODS_PARAM_CONT."$goodId');\">
                    <img src='$host/icons/pencil.png'></a>";
            
            if ($PatentParam->haveRelation()) {
            $value .= "  <a href=# title='”далить' 
                onClick=\"  deleteGoodParamFE($goodId, {$gp->id},$paramId,'"._GOODS_PARAM_EDT_MSG."$goodId$paramId','"._GOODS_PARAM_CONT."$goodId');\">
                    <img src='$host/icons/delete.png'>
            </a>";
            }   
            
            echo"</td></tr>";
        }
        if ($PatentParam->haveRelation()){
        $value.= "<tr><td><button id='add-button$goodId$paramId'>ƒобавить</button></td></tr>";
        //$value.= "<tr><td><input type='BUTTON' value='ƒобавить' onClick=\"setGoodsParamValFE(0, $goodId, $paramId,'"._GOODS_PARAM_EDT_MSG."$goodId$paramId','"._GOODS_PARAM_CONT."$goodId');\"></input></td></tr>";
        $jScript = '        $( "#add-button'.$goodId.$paramId.'" )
            .button()
            .click(function() {
                setGoodsParamValFE(0, '.$goodId.', '.$paramId.',"'._GOODS_PARAM_EDT_MSG.$goodId.$paramId.'","'._GOODS_PARAM_CONT.$goodId.'");
            });';        
        }
        $value .= "</table>";    
        //$value = $goodsParam;
    
    //echo "«начение: ".$value;        
    $value.= "<script>$jScript</script>";
            
    }
    echo $value;
    echo "</div>";
?>