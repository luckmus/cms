<?php
    //include "modules/em/init_module.php"; 
    include "modules/FRONTEND/skin/{$GLOBALS[SKIN_VAR]}/em_goods_viewer.php";
    
    $catalog = new GoodsCatalog($viewCategId);
    //print '<div style="width: 100%; height: 100%;" id="lcont"> ';
    print $catalog->getCatalogView();
    //print '</div>';
?>