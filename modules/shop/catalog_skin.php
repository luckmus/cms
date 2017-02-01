<?php
    //include "modules/em/init_module.php"; 
    include "modules/FRONTEND/skin/{$GLOBALS[SKIN_VAR]}/em_goods_viewer.php";
    
    $catalog = new GoodsCatalog($viewCategId);
    print '<div style="width: 80800px; height: 377px;" id="lcont"> ';
    print $catalog->getCatalogView();
    print '</div>';
?>