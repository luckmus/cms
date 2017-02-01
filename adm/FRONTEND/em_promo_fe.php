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
    include  "../"._MODULES_EM_PATH ."em_promo.php";
    $dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
    mQuery("SET NAMES 'cp1251'", $dbh); 
    $randId = rand(100,10000);
    $id = $_GET['id'];
    $isArch = $_GET['isArch'];
    $promo = new Promo($id);
    $saveBtns = 
    "<button id='save-btn-$id'>Сохранить</button>
    <button id='add-btn-$id'>Добавить</button>
    <button id='copy-btn-$id'>Копировать</button>
    <button id='delete-btn-$id'>Удалить</button>";

     echo "$saveBtns"; 
     $descCont = "promo-desc-$id-$randId";
     
                
    //слой для отображения сообщений
    $goodsEdtMagPlcId = _PROMO_EDT_MSG."{$id}_"; 
    //print "<form><textarea name=\"news\" cols=\"30\" rows=\"5\">$goods</textarea><br></form>";  
    echo "<div id='$goodsEdtMagPlcId'></div>";     
  $descCont = "goods-desc-$id-$randId";
  $datepicker = "datepicker$id";
  $aname = "promo_name_$id";
  $avalue = "promo_value_$id";
  print "<label>Наименоание: <input id='$aname' type='text' value='{$promo->name}'></label>";
  print "<label>Величина скидки: <input id='$avalue' type='text' value='{$promo->value}' maxlength='2'></label>";
  print "<label>Дата окончания: <input type='text' value='' id='$datepicker'></label>";
  print "<form><label>Описание: <textarea id=\"$descCont\" name=\"goods\" cols=\"70\" rows=\"20\">{$promo->descr}</textarea></label><br></form>";  
  
  $jsScript = "";

    $jsScript .= "    
          \$( '#save-btn-$id' )
            .button()
            .click(function() {              
                    savePromoBE($id, '$aname', '$descCont', '$avalue', '$datepicker', '"._MAIN_PROMO_CONT."', 4);
            });
          \$( '#add-btn-$id' )
            .button()
            .click(function() {     
                     addPromoFE('$goodsEdtMagPlcId','"._ALL_PROMO_CONT."');
            });            
          \$( '#copy-btn-$id' )
            .button()
            .click(function() {     
                     copyPromoFE($id,'$goodsEdtMagPlcId','"._ALL_PROMO_CONT."');
            });     
          \$( '#delete-btn-$id' )
            .button()
            .click(function() {     
                deletePromoFE($id,'$goodsEdtMagPlcId','"._ALL_PROMO_CONT."');
            });      

            tinyMCE.execCommand('mceAddControl', false, '$descCont');
            $( '#$datepicker' ).datepicker({
                minDate: 0,
                dateFormat: 'yy-mm-dd'
            }).val('{$promo->endDate}');
            
";  
  echo "<script>$jsScript</script>";
                                                                                                                           
?>

