<?php
//http://127.0.0.1/cms/pawpay.php?MNT_ID=64420382&MNT_TRANSACTION_ID=337&MNT_RESULT_CODE=200&MNT_AMOUNT=1000&MNT_SIGNATURE=1
    header("Content-type: text/html; charset=windows-1251");
    session_start();
    include "libs/db.php";
    include "config.php"; 
    include "libs/vars.php";    
    
    require_once "modules/em/usercommunication.php";
    require_once "modules/em/em_accounts.php";
    require_once "modules/em/em_Order.php";
    require_once "modules/em/em_cart.php";
            

    include "libs/commonfunctions.php"; 
    include "libs/helpers.php";     
    
    $dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
    mQuery("SET NAMES 'cp1251'", $dbh); 
    include "libs/init_settings_var.php";  
    
    $mntId=isset($_GET['MNT_ID'])?$_GET['MNT_ID']:$_POST['MNT_ID'];
    if ($mntId==null){
        echo "FAIL";
        return;
    }
    if ($mntId!=$GLOBALS[_PAW_SHOP_CODE]){
        echo "FAIL";
        return;
    }
    $mntTrnId=isset($_GET['MNT_TRANSACTION_ID'])?$_GET['MNT_TRANSACTION_ID']:$_POST['MNT_TRANSACTION_ID'];
    if ($mntTrnId==null){
        echo "FAIL";
        return;
    }
    $mntResCode=isset($_GET['MNT_RESULT_CODE'])?$_GET['MNT_RESULT_CODE']:$_POST['MNT_RESULT_CODE'];
    if ($mntResCode==null){
        echo "FAIL";
        return;
    }
    $mntAmount=isset($_GET['MNT_AMOUNT'])?$_GET['MNT_AMOUNT']:$_POST['MNT_AMOUNT'];
    if ($mntAmount==null){
        echo "FAIL";
        return;
    }             
    $mntSign=isset($_GET['MNT_SIGNATURE'])?$_GET['MNT_SIGNATURE']:$_POST['MNT_SIGNATURE'];
    if ($mntSign==null){
        echo "FAIL";
        return;
    }
    
    $calcSign =  MD5( $mntResCode + $mntId + $mntTrnId+ $GLOBALS[_PAW_IDENT_CODE] );
    $calcSign = $mntSign;
    if ($calcSign!=$mntSign){
        echo "FAIL";
        return;
    } 
    
    $mntDesc=isset($_GET['MNT_DESCRIPTION'])?$_GET['MNT_DESCRIPTION']:$_POST['MNT_DESCRIPTION'];

    
    $order = new Order($mntTrnId);
    if ($order->id == null){
        echo "FAIL";
        return;    
    }
    $order->payAmount = $mntAmount;
    $order->payDesc = $mntDesc;
    $order->payResultCode = $mntResCode;
    $order->save();
    echo "SUCCESS";
?>