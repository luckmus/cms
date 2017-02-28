<?php

    include "modules/FRONTEND/skin/common_skin/em_cl_order_viewer.php";
    
    $view = new ClOrderView(addslashes($_GET['id']),$_GET['token']);
    
    //print '<div style="width: 100%; height: 100%;" id="lcont"> ';
    print $view->getView();
    //print '</div>';

?>