<?php
    header("Content-type: text/html; charset=windows-1251");
    require_once "../libs/vars.php";    
    include "../../libs/db.php";
    include "../../config.php"; 
    //include "libs/vars.php";
     include "../../libs/helpers.php";
     include "../../libs/vars.php";
     include "../../libs/commonfunctions.php";
     include "../libs/helpers.php";                    
    include  "../"._MODULES_EM_PATH ."parameter.php";
    include  "../"._MODULES_EM_PATH ."em_category.php";
    include  "../"._MODULES_EM_PATH ."em_goods.php";
    $dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
    mQuery("SET NAMES 'cp1251'", $dbh); 
    $randId = rand(100,10000);
    $id = $_GET['id'];
    $isArch = $_GET['isArch'];
    $goodsOne = new Goods($id);
    $isArch =  $goodsOne->isArchivate;
    if ($isArch==0){    
    $saveBtns = 
    "<button id='save-btn-$id'>Сохранить</button>
    <button id='add-btn-$id'>Добавить</button>
    <button id='copy-btn-$id'>Копировать</button>
    <button id='delete-btn-$id'>Удалить</button>
    <button id='arch-btn-$id'>В архив</button>";
    }
    else{
    $saveBtns = 
    "<button id='save-btn-$id'>Сохранить</button>
    <button id='delete-btn-$id'>Удалить</button>
    <button id='unarch-btn-$id'>В товары</button>";    
    }
     echo "$saveBtns"; 
     
    //слой для отображения сообщений
    $goodsEdtMagPlcId = _GOODS_EDT_MSG."{$goodId}_"; 
    //print "<form><textarea name=\"news\" cols=\"30\" rows=\"5\">$goods</textarea><br></form>";  
    echo "<div id='$goodsEdtMagPlcId'></div>";     
//    echo "<form>";          
echo "<table border=0>";
echo "<tr><td>";    
   
    echo "<table border=0>";
    echo "<tr>";
    echo "<td>";
    print "<b>Наименование товара:</b><br>"; 
    echo "</td>";
    echo "<td>";
    print "<b>Категория товара:</b><br>";
    echo "</td>";
    echo "</tr>";    
    echo "<tr>";
    echo "<td>";
    $nameCont = "goods-name-$id";
    print "<input type=\"TEXT\" name=\"name\" id=\"$nameCont\" size=\"40\" maxlength=\"50\" value=\"{$goodsOne->name}\">"; 
    echo "</td>";
    echo "<td>";   
  #категория
  
  $catCont = "category$id";
  print "<select  id= '$catCont'>";
  $categs = new Categoryes();
  
  $allCats = $categs->catArray;
  for($i = 0; $i<count($allCats); $i++){
    $cat =  $allCats[$i];   
    $cat->Load();
    if ($cat->id == $goodsOne->categoryid){
        $sel = 'SELECTED';
        $goodCateg = $cat;
    }
      else{
        $sel = '';    
    }
    print "<option $sel value={$cat->id}>{$cat->name}";
  }
  print "</select><br>";

    echo "</td>";
    echo "</tr>";
  
 echo "</table>"; 
 echo "</td></tr>";
 echo "<tr><td>";
 #выведу список параметров товара
 $paramFace = getHost()._ADM_FRONTEND."em_goods_param_fe.php";
 $aviableParams = $goodCateg->getAviableParameters();
 echo "<div><br>";
 echo "<div id='"._GOODS_PARAM_CONT."{$goodsOne->id}'>";
 echo "<ul>"; 
 for ($i=0; $i<count($aviableParams); $i++){
     $param = $aviableParams[$i];
     $paramUrl = $paramFace."?goodId={$goodsOne->id}&paramId={$param->id}";
     echo "<li><a href='$paramUrl'><span>{$param->name}  </span></a></li>"; 
 }
 echo "</ul>"; 
 echo "</div>";
 echo "</div>";
 echo "</td></tr>";
 echo "<tr><td>"; 
  print "<b>Изображение товара</b>:<br>";
  $url = $_SERVER['DOCUMENT_ROOT']."/".getUri()._UploadDir;
  $imgCont = "goods-img-$id";
  print "<select name='imagefile' id='$imgCont' style='width:400px'>";
  $AllFilesList = LoadFromDir($url);
  foreach($AllFilesList as $file){     
      if ($goodsOne->imagefile==$file[2])
          $imgSelected = 'SELECTED';
      else
          $imgSelected = '';
    print "<option value='{$file[2]}' $imgSelected>{$file[1]}";
  }
  print "</select><br>";
 echo "</td></tr>";
 echo "<tr><td>";  
  print "<b>Описание товара.</b><br>";
  $descCont = "goods-desc-$id-$randId";
  print "<form><textarea id=\"$descCont\" name=\"goods\" cols=\"70\" rows=\"20\">{$goodsOne->desc}</textarea><br></form>";  
 echo "</td></tr>";
 echo "<tr><td>";  
  print "<b>Описание страницы для поиcковых машин</b><br>";
  $MDescrCont = "goods-meta-desc-$id";
  print "<textarea  name=\"metadescr\" id=\"$MDescrCont\" cols=40 rows=5>";
  print "{$goodsOne->metadescription}";
  print "</textarea><br>";
  print "<b>Ключевые для поиcковых машин</b> (перечисление через запятую):<br>";
  $MWordsCont = "goods-meta-words-$id" ;
  print "<input type=text  name=\"metawords\" size=\"59\" id=\"$MWordsCont\" maxlength=\"255\" value = \"{$goodsOne->metakeywords}\"><br><br>";    
       
 
   
  //echo "</form>";
 echo "</td></tr>";
 echo "</table>";  
  //$JScript = "\$('#"._GOODS_PARAM_CONT."{$goodsOne->id}').tabs();  ";
  $jsScript = "
  \$('#"._GOODS_PARAM_CONT."{$goodsOne->id}').tabs().addClass('ui-tabs-vertical ui-helper-clearfix');
  \$('#"._GOODS_PARAM_CONT."{$goodsOne->id}').removeClass('ui-corner-top').addClass('ui-corner-left');"; 
  if ($isArch==0){
    $jsScript .= "    
          \$( '#save-btn-$id' )
            .button()
            .click(function() {              
                    saveGoodsBE({$goodsOne->id}, '$catCont', '$nameCont', '$descCont', '$imgCont', '$MDescrCont', '$MWordsCont', '"._MAIN_GOODS_CONT."');
            });
          \$( '#add-btn-$id' )
            .button()
            .click(function() {     
                    addGoodsFE('$goodsEdtMagPlcId','"._ALL_GOODS_CONT."');
            });            
          \$( '#copy-btn-$id' )
            .button()
            .click(function() {     
                    copyGoodsFE($id,'$goodsEdtMagPlcId','"._ALL_GOODS_CONT."');
            });     
          \$( '#delete-btn-$id' )
            .button()
            .click(function() {     
                    deleteGoodsFE($id,'$goodsEdtMagPlcId','"._ALL_GOODS_CONT."');
            });      
          \$( '#arch-btn-$id' )
            .button()
            .click(function() {     
                    archivateGoodsFE($id,'$goodsEdtMagPlcId','"._ALL_GOODS_CONT."');
            }); 
            tinyMCE.execCommand('mceAddControl', false, '$descCont');
";  
  }
  else{
    $jsScript .= "    
          \$( '#save-btn-$id' )
            .button()
            .click(function() {              
                    saveGoodsBE({$goodsOne->id}, '$catCont', '$nameCont', '$descCont', '$imgCont', '$MDescrCont', '$MWordsCont', '"._MAIN_GOODS_CONT."');
            });
          \$( '#delete-btn-$id' )
            .button()
            .click(function() {     
                    deleteGoodsFE($id,'$goodsEdtMagPlcId','"._ALL_GOODS_CONT."');
            });
            \$( '#unarch-btn-$id' )
            .button()
            .click(function() {     
                    unArchivateGoodsFE($id,'$goodsEdtMagPlcId','"._ALL_GOODS_CONT."');
            }); 
            tinyMCE.execCommand('mceAddControl', false, '$descCont');              
            ";
  }  
  echo "<script>$jsScript</script>";
  
?>

