<?php
    
    function findIndexByName($name){
        $url = genBaseUrl('zipcity')."&city=".urlencode($name);
        $res = file_get_contents($url);
        echo $res;
    }
    
    function getDeliveryPosobility($index, $price, $weight ){
     $url = genBaseUrl('tarif')."&zip=$index&weight=$weight&type=+post&price=$price&price_assess=$price&region=78&allpost=1";
     echo "$url";
     $res = file_get_contents($url);
     echo $res;   
    }
    
    function genBaseUrl($func){
        return "http://is.b2cpl.ru/portal/client_api.ashx?client=test&key=test&func=$func";
        
    }
?>