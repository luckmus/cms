<?php
    //include "modules/em/init_module.php"; 
    include "modules/FRONTEND/skin/{$GLOBALS[SKIN_VAR]}/em_cart_viewer.php";
    
    $cart = new Cart();
    
    $cartView = new CartView($cart);
    //print '<div style="width: 100%; height: 100%;" id="lcont"> ';
    print $cartView->getView();
    //print '</div>';
?>