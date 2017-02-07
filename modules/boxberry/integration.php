<?php

    function getDeliveryPosobility($index, $price, $weight ){
        
     $url = genBaseUrl('DeliveryCosts')."&weight=$weight&target=010&ordersum=$price&deliverysum=$price&paysum=$price&zip=$index";
     //echo "$url";
     $res = file_get_contents($url);
     return  ($res);   
    }
    
    function genBaseUrl($func){
        //return "http://127.0.0.1/cms/bb_emul.php?token=".getToken()."&method=$func";
        return "http://api.boxberry.de/json.php?token=".getToken()."&method=$func";
        
    }
    
    function getToken(){
        return "24289.rrpqfeae";   
    }
    
    
?>