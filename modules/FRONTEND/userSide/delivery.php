<?php
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); 
header("Content-type: text/html; charset=windows-1251");

//require_once "../../b2cpl/integration.php";    
require_once "../../boxberry/integration.php";    


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
    case "decline":
        $trackNum= strip_tags($_GET['track_num']);  
        echo parselDel($trackNum);
    break;
    case "add":
        include "../../../libs/db.php";
        include "../../../config.php";   
        $dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
        //mQuery('SET character_set_database = cp1251');
        mQuery("SET NAMES 'cp1251'", $dbh);      
        require_once "../../em/usercommunication.php";
        require_once "../../em/em_accounts.php";
        require_once "../../em/em_goods.php";
        require_once "../../em/em_Order.php";
        $id= strip_tags($_GET['orderId']);  
        echo addParcel($id);
    break;
    default:
        echo '{"flag_error": -1, "comment": "Неизвестная операция"';
    break;
	
}
?>