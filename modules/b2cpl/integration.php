<?php
    
    function findIndexByName($name){
        $url = genBaseUrl('zipcity')."&city=".urlencode($name);
        $res = file_get_contents($url);
        return $res;
    }
    
    function getDeliveryPosobility($index, $price, $weight ){
    $res = preg_match("/[à-ÿÀ-ß]+/",$index, $matches);
    if (count($matches)>0){
        $find = findIndexByName($index);
        $findJ = json_decode($find);
        if (($findJ!=null)&&($findJ->flag_error==0)){
            $index = $findJ->zip;
        }
        else{
            return $find;   
        }
        
    }
        
     $url = genBaseUrl('tarif')."&zip=$index&weight=$weight&type=+post&price=$price&price_assess=$price&region=78&allpost=1";
     //echo "$url";
     $res = file_get_contents($url);
     return $res;   
    }
    
    function genBaseUrl($func){
        return "http://is.b2cpl.ru/portal/client_api.ashx?client=test&key=test&func=$func";
        
    }
?>