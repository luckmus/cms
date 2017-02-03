<?php
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); 
header("Content-type: text/html; charset=windows-1251");

require_once "../../b2cpl/integration.php";    


$action=$_GET['action'];
switch(strtolower($action)){
	case "zipcity":
        $city= strip_tags($_GET['city']);  
	    echo findIndexByName($city);
	break;
    
    case "tarif":
        $index= strip_tags($_GET['index']);  
        $price= strip_tags($_GET['price']);  
        $weight= strip_tags($_GET['weight']);  
        echo getDeliveryPosobility($index, $price, $weight );
    break;
    default:
        echo '{"flag_error": -1, "comment": "Неизвестная операция"';
    break;
	
}
?>