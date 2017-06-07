<?php
//https://wood-burg.ru/pawpay.php?MNT_ID=64420382&MNT_TRANSACTION_ID=381&MNT_OPERATION_ID=149923346&MNT_AMOUNT=1.96&MNT_CURRENCY_CODE=RUB&MNT_TEST_MODE=0&MNT_SIGNATURE=a286fbc303e857d6c7ecbcc0240b6baa&paymentSystem.unitId=1686945&MNT_CORRACCOUNT=303&MNT_FEE=-0.06&cardnumber=525477******5071
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
    addLog("pay check $mntId");
    if ($mntId==null){
        echo "FAIL";
        addLog("pay check fail 1");    
        return;
    }
    if ($mntId!=$GLOBALS[_PAW_SHOP_CODE]){
        echo "FAIL";
        addLog("pay check fail 2");
        return;
    }
    $mntTrnId=isset($_GET['MNT_TRANSACTION_ID'])?$_GET['MNT_TRANSACTION_ID']:$_POST['MNT_TRANSACTION_ID'];
    if ($mntTrnId==null){
        echo "FAIL";
        addLog("pay check fail 3");
        return;
    }
    
    /*
    $mntResCode=isset($_GET['MNT_RESULT_CODE'])?$_GET['MNT_RESULT_CODE']:$_POST['MNT_RESULT_CODE'];
    if ($mntResCode==null){
        echo "FAIL";
        addLog("pay check fail 4");
        return;
    }
    */
    $mntOperId=isset($_GET['MNT_OPERATION_ID'])?$_GET['MNT_OPERATION_ID']:$_POST['MNT_OPERATION_ID'];
    if ($mntOperId==null){
        echo "FAIL";
        addLog("pay check fail 4");
        return;
    }
    $mntCurCode=isset($_GET['MNT_CURRENCY_CODE'])?$_GET['MNT_CURRENCY_CODE']:$_POST['MNT_CURRENCY_CODE'];
    if ($mntCurCode==null){
        echo "FAIL";
        addLog("pay check fail 41");
        return;
    }
    $mntTestMode=isset($_GET['MNT_TEST_MODE'])?$_GET['MNT_TEST_MODE']:$_POST['MNT_TEST_MODE'];
    if ($mntTestMode==null){
        echo "FAIL";
        addLog("pay check fail 42");
        return;
    }
    $mntSubscr=isset($_GET['MNT_SUBSCRIBER_ID'])?$_GET['MNT_SUBSCRIBER_ID']:$_POST['MNT_SUBSCRIBER_ID'];
    if ($mntSubscr==null){
        $mntSubscr = ""; 
    }
    $mntAmount=isset($_GET['MNT_AMOUNT'])?$_GET['MNT_AMOUNT']:$_POST['MNT_AMOUNT'];
    if ($mntAmount==null){
        echo "FAIL";
        addLog("pay check fail 5");
        return;
    }             
    $mntSign=isset($_GET['MNT_SIGNATURE'])?$_GET['MNT_SIGNATURE']:$_POST['MNT_SIGNATURE'];
    if ($mntSign==null){
        echo "FAIL";
        addLog("pay check fail 6");
        return;
    }
    
    //$calcSign =  MD5( $mntResCode + $mntId + $mntTrnId+ $GLOBALS[_PAW_IDENT_CODE] );
    $calcSign = MD5($mntId + $mntTrnId + $mntOperId +$mntAmount + $mntCurCode + $mntSubscr + $mntTestMode + $GLOBALS[_PAW_IDENT_CODE]);

    $calcSign = $mntSign;
    if ($calcSign!=$mntSign){
        echo "FAIL";
        addLog("pay check fail 7");
        return;
    } 
    
    $mntDesc=isset($_GET['MNT_DESCRIPTION'])?$_GET['MNT_DESCRIPTION']:$_POST['MNT_DESCRIPTION'];

    
    $order = new Order($mntTrnId);
    if ($order->id == null){
        echo "FAIL";
        addLog("pay check fail 8 mntTrnId:$mntTrnId");
        return;    
    }
    
    $order->payAmount = $mntAmount;
    $order->payDesc = $mntDesc;
    $order->payResultCode = 200;
    $order->save();
    addLog("SUCCESS");   
    $userMail = $order->geuUserMail(); 
    if (isset($userMail)){
        $com = new UserCommunication();
        $com->init();
        $com->sendMailFmooManager($userMail,"Успешная оплата заказа на сайте "._title, "Для просмотра статуса своего заказа перейдите по ссылке: {$order->getOrderLink()}");    
    }else{
        addLog("mail not setted");
    }

    echo "SUCCESS";
    exit;
?>  
