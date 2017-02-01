<?php
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
    $categ->Load();
    echo "<table border=0 width=100%>";
    echo "<tr>";
    echo "<td>";
    print "</b>Наименование категории</b><br>";
    print "<input type=\"TEXT\" name=\"name$id\" id=\"name$id\" size=\"25\" maxlength=\"25\" value=\"{$categ->name}\"><br>";
    print "<b>Изображение категории</b>:<br>";
    $url = $_SERVER['DOCUMENT_ROOT']."/".getUri()._UploadDir;
    print "<select name='imagefile$id' id='imagefile$id' style='width:350px'>";
    $AllFilesList = LoadFromDir($url);
    foreach($AllFilesList as $file){
      if ($imagefile==$file[0])
          $imgSelected = 'SELECTED';
      else
          $imgSelected = '';
      print "<option value='{$file[0]}' $imgSelected >{$file[0]}</option>";
    }
    print "</select>";
    print "<br><b>Описание категории:</b><br>";
    print "<textarea name='descr$id' id='descr$id' cols=\"40\" rows=\"10\">{$categ->description}</textarea><br>";
    echo "</td>";
    echo "<td style='vertical-align: top;'>";
    $delIcon = "../icons/delete.png"; 
    $upIcon = "../icons/up.png"; 
    $downIcon = "../icons/down.png"; 
echo'  
<div id="users-contain" class="ui-widget" style="vertical-align: top;width:350px;">
   <p>Характеристики категории товаров:</p>
  <table id="users" class="ui-widget ui-widget-content">
        <thead>
            <tr class="ui-widget-header ">
                <th>Наименование</th>
                <th>Свойства</th>

            </tr>

        </thead>
        <tbody>
        ';
        $params = $categ->parameters;
        for($i=0;$i<count($params); $i++){
            echo "            <tr>
                <td>{$params[$i]->name} </td>
                
                <td>                            
                <a href='#'><img src='{$delIcon}'     
                    onClick=\"deleteCatParamFE($id, '{$params[$i]->id}','msgDelCatParamPlace$id','"._MAIN_CATEG_CONT."');\"></a>
                <a href='#'><img src='{$upIcon}' width='20'  
                    onClick=\"moveCatParam($id, '{$params[$i]->id}',"._MAIN_CATEG_CONT.",1);\"></a>
                <a href='#'><img src='{$downIcon}' width='20'    
                    onClick=\"moveCatParam($id, '{$params[$i]->id}',"._MAIN_CATEG_CONT.",0);\"></a>
                </td>
            </tr>";
        }
echo "  <tr>
            <td><button id='add-cparam$id'>Добавить характеристику</button></td>
            <td></td>
        </tr>";
echo ' </tbody>
    </table>
</div>    ';    
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>";
    echo '<button id="save-cat'.$id.'">Сохранить</button>&nbsp;
          <button id="del-cat'.$id.'">Удалить</button> &nbsp;
          <button id="add-cat'.$id.'">Новая</button>';
    echo "</td>";
    echo "<td>";
    //echo '<button id="add-cat'.$id.'">Добавить новую</button> ';
    echo "</td>";
    
    echo "</tr>";
    
    echo "</table>";
    //диплог на добавление категории
echo '          
<div id="dialog-form'.$id.'" title="Категории">
    <p class="validateTips" id="tipsid" >Добавление новой категории</p>

    <form>
    <fieldset>
        <label for="name'.$id.'">Наименование</label>
        <input type="text" name="newcat'.$id.'" id="newcat'.$id.'" class="text ui-widget-content ui-corner-all" />

    </fieldset>
    </form>
</div>                             
';    
    #диалог на добаление параметра категории
    echo "<div id='dialog-form-addparam$id' title='Категории'></div>";
    //место для вывода сообщений
    echo "<div id='msgDelCatParamPlace$id'></div>";    
    $saveCatUrl = getHost()._ADM_BACKEND."em_category_params_be.php"; 
    $addCatParamUrlFE = getHost()._ADM_FRONTEND."em_add_categ_param.php"; 
    $addCatParamUrlBE = getHost()._ADM_BACKEND."em_category_params_be.php?mode=addparam&id=$id"; 
$jsScript = '$(function() {

        $( "#dialog:ui-dialog" ).dialog( "destroy" );
        
        var name = $( "#name'.$id.'" )
        

        
        $( "#dialog-form'.$id.'" ).dialog({
            autoOpen: false,
            height: 300,
            width: 350,
            modal: true,
            buttons: {                                                                                     
                "Сохранить": function() {

                 var URL = "";
                    URL = "'.$saveCatUrl.'?mode=add&name="+$( "#newcat'.$id.'" ).val();
                 //alert(URL);
                     $.ajax({
                     url: URL,             // указываем URL и
                     success: function (data, textStatus) { // вешаем свой обработчик на функцию success
                        if(data!="1"){
                            alert("Ошибка сохранении категории");
                        }
                        else{
                             //reloadCategTabs("'._ALL_CATEG_CONT.'");
                             reloadTabs("'._ALL_CATEG_CONT.'", "adm/jCategory.php");
                        }
    }
});                    
                     $( this ).dialog( "close" );
                },
                "Отмена": function() {

                    $( this ).dialog( "close" );
                }
            },
            
            close: function() {
                allFields.val( "" ).removeClass( "ui-state-error" );
            }
        });
        
        
        $( "#save-cat'.$id.'" )
            .button()
            .click(function() {                    
                    var URL = "";
                    URL = "'.$saveCatUrl.'?mode=edit&id='.$id.'&name="+$( "#name'.$id.'" ).val()+"&descr="+$( "#descr'.$id.'" ).val()+"&img="+$( "#imagefile'.$id.'" ).val();
                    //alert(URL);
                     $.ajax({
                     url: URL,             // указываем URL и
                     success: function (data, textStatus) { // вешаем свой обработчик на функцию success
                        if(data!="1"){
                            alert("Ошибка сохранении категории");
                        }
                        else{
                             $('._MAIN_CATEG_CONT.').tabs("load", $('._MAIN_CATEG_CONT.').tabs("option", "selected"));
                        }
    }
});                
            });
        $( "#add-cat'.$id.'" )
            .button()
            .click(function() {     
                    $( "#dialog-form'.$id.'" ).dialog( "open" );               
                   
            }); 
        $( "#del-cat'.$id.'" )
            .button()
            .click(function() {                                        
                    deleteCatFE('.$id.',"msgDelCatParamPlace'.$id.'","'._ALL_CATEG_CONT.'");
    
});                       
            
        $( "#add-cparam'.$id.'" )
            .button()
            .click(function() {     
                    //подгружу контент сообщения
                    var URL = "";
                    URL = "'.$addCatParamUrlFE.'?id='.$id.'";
                     $.ajax({
                     url: URL,             // указываем URL и
                     success: function (data, textStatus) { // вешаем свой обработчик на функцию success
                              $( "#dialog-form-addparam'.$id.'" ).html(data);
                              $( "#dialog-form-addparam'.$id.'" ).dialog( "open" );                      
                     }
                     });                                  
                   
            }); 
        $( "#dialog-form-addparam'.$id.'" ).dialog({
            autoOpen: false,
            height: 300,
            width: 350,
            modal: true,
            buttons: {                                                                                     
                "Добавить": function() {       
                     addCategParam("'.$addCatParamUrlBE.'", $("#paramid'.$id.'").val(),$( this ),"'._MAIN_CATEG_CONT.'");
                     //$( this ).dialog( "close" );
                },
                "Отмена": function() {

                    $( this ).dialog( "close" );
                }
            },
            
            close: function() {
                allFields.val( "" ).removeClass( "ui-state-error" );
            }
        });                        
    });
';
echo "<script>$jsScript</script>"    
?>