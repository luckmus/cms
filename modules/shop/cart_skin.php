<?php
    //include "modules/em/init_module.php"; 
    include "modules/FRONTEND/skin/{$GLOBALS[SKIN_VAR]}/em_cart_viewer.php";
    
    $cart = new Cart();
    
    $cartView = new CartView($cart);
    print '<div style="width: 80800px; height: 377px;" id="lcont"> ';
    print $cartView->getView();
    print '</div>';
?>