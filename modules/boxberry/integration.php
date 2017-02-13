<?php

    function getDeliveryPosobility($index, $price, $weight ){
        
     $url = genBaseUrl('DeliveryCosts')."&weight=$weight&target=010&ordersum=$price&deliverysum=$price&paysum=$price&zip=$index";
     //echo "$url";
     $res = file_get_contents($url);
     return  ($res);   
    }
    
    function parselDel($trackNum){
    $url = genBaseUrl('ParselDel')."&ImId=$trackNum";
     //echo "$url";
     $res = file_get_contents($url);
     return  ($res);
    }
    
    function addParcel($orderId){
        $order = new Order($orderId);
        
    }
    
    function prepareData($order){
         $SDATA=array();
         if ($order->trackNum!=null){
            $SDATA['updateByTrack']='�������-��� ����� ��������� �������';
         }
         $di = new DeliveryInfo($order->adres);
         $SDATA['order_id']=$order->id;
         //$SDATA['barcode']='�����-��� ������';
         $SDATA['price']=$order->totalSum;
         $SDATA['payment_sum']=$order->totalSum;
         $SDATA['delivery_sum']=$di->deliveryPrice;
         //$SDATA['vid']='��� �������� (1/2)';
         if ($di->method==2){
            $SDATA['shop']=array(
             'name'=>$di->pvzId,
             //'name1'=>'��� ������ �����������'
             );
             $custName = '';
             $phone = '';
             $email = '';
             $address = '';
             if ($order->user->login==null){
                 $custName = "{$order->firstName} {$order->lastname}";
                 $phone = $order->tel;
                 $email = $order->email;
             }else{
                $custName  = "{$order->user->firstName} {$order->user->lastname}";
                $phone = $order->user->tel;
                $email = $order->user->email;
                $address = $order->user->adres;
             }
             
             $SDATA['customer']=array(
             'fio'=>$custName,
             'phone'=>$phone,
             //'phone2'=>'���. ����� ��������',
             'email'=>$email,
             //'name'=>'������������ �����������',
             'address'=>$address
             //'inn'=>'���',
             //'kpp'=>'���',
             //'r_s'=>'��������� ����',
             //'bank'=>'������������ �����',
             ///'kor_s'=>'���. ����',
             //'bik'=>'���'
             );
         }if ($di->method==3){
             $SDATA['kurdost'] = array(
             'index' => $di->index,
             'citi' => $di->city,
             'addressp' => $di->address,
             //'timesfrom1' => '����� ��������, ��',
             //'timesto1' => '����� ��������, ��',
             //'timesfrom2' => '�������������� �����, ��',
             //'timesto2' => '�������������� �����, ��',
             //'timep' => '����� �������� ��������� ������',
             'comentk' => $order->description
             );
         }
         

         $SDATA['items']=array();
         $SDATA['weights']=array( );
         
         $dicount = $order->discount;
         $nds = 18;
         $price = $goodsOne->goodsprice;
         $price = $price- ($price*$dicount)/100; 
         $ndsVal = ($price*$nds)/100;
         
         foreach($order->child as $items){
             $goodsOne = new Goods($item->goodsId); 
             $gd = array(
                     'id'=>$items->goodsId,
                     'name'=>$goodsOne->name,
                     'UnitName'=>'��',
                     'nds'=>$ndsVal,
                     'price'=>$price,
                     'quantity'=>$item->cnt
                 );
             array_push($SDATA['items'], $gd);
             array_push($SDATA['weights'], 0);
         }
                
    }
    
    function genBaseUrl($func){
        //return "http://127.0.0.1/cms/bb_emul.php?token=".getToken()."&method=$func";
        return "http://api.boxberry.de/json.php?token=".getToken()."&method=$func";
        
    }
    
    function getToken(){
        return "24349.rrpqdafe";   
    }
    
    
?>