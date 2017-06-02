<?php
    header("Content-type: text/html; charset=windows-1251");
    session_start();
    include "../../../config.php"; 
    include "../../../libs/db.php";    
    include "../../../libs/vars.php";    
    
    Includer::initOrder();
    //include "../../em/em_Order.php";
    include "../../em/em_goods.php"; 
    include "../../em/parameter.php"; 
    include "../../em/em_promo.php"; 
    include "../../../libs/commonfunctions.php"; 
    include "../../../libs/helpers.php";     
    
    $dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
    mQuery("SET NAMES 'cp1251'", $dbh); 
    include "../../../libs/init_settings_var.php";    
    $rcontrdig = stripslashes($_POST['rcontrdig']);    
    
    if ($ErrMes != '')         
    {
        echo '{"err": "'.$ErrMes.'"}';
        return;   
    }         
    $order = new Order(null);
    $ErrMes = $order->checkForm($rcontrdig);
    $order->firstName =  convertToWIN1251(stripslashes($_POST['name']));
    $order->lastname = convertToWIN1251(stripslashes($_POST['lastname']));
    $order->tel = convertToWIN1251(stripslashes($_POST['tel']));
    $order->email = convertToWIN1251(stripslashes($_POST['email']));
    $order->adres = convertToWIN1251(stripslashes($_POST['delivery']));
    $order->description = convertToWIN1251(stripslashes($_POST['descr']));
    $promoName = convertToWIN1251(stripslashes($_POST['promo']));
    $order->setUser(stripslashes($_POST['userId']));    
    $order->iscomlete = 0;                                               
    $order->cnt = 0;
    $fromCart = $_POST['fromCart'];
    
    $errmsg = $order->checkForm($rcontrdig);
    if ($errmsg!=''){
        echo '{"err": "'.$errmsg.'"}';
        return;
    }
    
    if (($fromCart!= null) && ($fromCart=='true')){
        $cart = new Cart();
        $promo = Promo::getPromoByName($promoName);
        $totalSumm = 0;
        $orderDisc = 0; 
        $goodsPrice = $cart->getTotal();                                            
        if (($promo!=null) && ($cart->getTotalCnt()>= $promo->minOrderCnt)){
            $totalSumm = $cart->getTotalWithDiscount($promo->value);
            $orderDisc = $promo->value;
        }
        else{
            $totalSumm =  $goodsPrice;
        }
        foreach($cart->list as $item){
            if ($item->cnt<=0){
                continue;
            }
            $childOrder = new Order(null);
            $childOrder->goodsId = $item->goods->id;
            $childOrder->goodsprice = $item->price;
            $childOrder->firstName =  convertToWIN1251(stripslashes($_POST['name']));
            $childOrder->lastname = convertToWIN1251(stripslashes($_POST['lastname']));
            $childOrder->tel = convertToWIN1251(stripslashes($_POST['tel']));
            $childOrder->email = convertToWIN1251(stripslashes($_POST['email']));
            //$childOrder->adres = convertToWIN1251(stripslashes($_POST['delivery']));
            $childOrder->description = convertToWIN1251(stripslashes($_POST['descr']));
            
            $childOrder->cnt = $item->cnt;
            $childOrder->setUser(stripslashes($_POST['userId']));    
            $childOrder->iscomlete = 0;                                               
            //$order->child[count($order->child)] = $childOrder;
            array_push($order->child, $childOrder);
        }
        $order->goodsprice = $goodsPrice;
        $order->totalSum = $totalSumm;
        $order->discount = $orderDisc;
    }else{
        //echo "single {$_POST['goodsId']} ";
        $order->goodsId = $_POST['goodsId'];
        $order->goodsprice = convertToWIN1251(stripslashes($_POST['price']));
    }
    
    
    $order->save();
    echo '{"id":'.$order->id.', "price":'.$totalSumm.', "err":0}';

?>
