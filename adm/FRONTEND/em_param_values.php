<?php
    header("Content-type: text/html; charset=windows-1251");
    include "../../libs/db.php";
    include "../../config.php"; 
    include "../libs/vars.php";
    include "../../libs/helpers.php";
    include "../". _MODULES_EM_PATH ."parameter.php"; 
    
    $dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
    //mQuery('SET character_set_database = cp1251');
    mQuery("SET NAMES 'cp1251'", $dbh);     
    $addURL = getHost()._ADM_BACKEND."em_param_values.php";
    $id = $_GET['id'];
    $param = new ParameterValues($id);
    $params = $param->getElements();
    if (count($params)==0){
        echo "Список значений параметра пуст<br>";
    }                                   
   
    else{
        
$delIcon = "../icons/delete.png";
$editIcon = "../icons/pencil.png";
//место для вывода сообщений
$dlgPlace = "add-param_btn-$id";
echo "<div class=\"message\" id='$dlgPlace'></div>";
echo'  
<div id="users-contain" class="ui-widget">
  
  <table id="users" class="ui-widget ui-widget-content">
        <thead>
            <tr class="ui-widget-header ">
                <th>Наименование</th>
                <th>Свойства</th>

            </tr>

        </thead>
        <tbody>
        ';
        
        for($i=0;$i<count($params); $i++){
            echo "            <tr>
                <td>{$params[$i]->value} </td>
                
                <td><a href='#'><img src='{$delIcon}'
                    onClick=\"deleteParamValueFE('{$params[$i]->id}','$dlgPlace', '"._MAIN_PARAM_CONT."');\"></a>&nbsp;
                    <a href='#' 
                    onClick=\"edtParamValueFE($id, '{$params[$i]->id}', '$dlgPlace', '"._MAIN_PARAM_CONT."');\"
                    ><img src='{$editIcon}'></a> 
                </td>
            </tr>";
        }

echo ' </tbody>
    </table>
</div>    ';
   

    
    }
    
echo '<button id="add-param-'.$id.'">Добавить</button> ';
$delConfirmURL = getHost()._DIALOGS_PATH.'confirm.php';

    $jsScript .= "    
          \$( '#add-param-$id' )
            .button()
            .click(function() {              
                    addParamValueFE($id, '$dlgPlace', '"._MAIN_PARAM_CONT."');
            });
";
echo "<script> $jsScript </script>";
?>
