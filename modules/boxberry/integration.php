<?php

    function getDeliveryPosobility($index, $price, $weight ){
        
     $url = genBaseUrl('DeliveryCosts')."&weight=$weight&target=010&ordersum=$price&deliverysum=$price&paysum=$price&zip=$index";
     //echo "$url";
     $res = file_get_contents($url);
     return  ($res);   
    }
    
    function parselDel($orderId){
    $order = new Order($orderId);
    
    $url = genBaseUrl('ParselDel')."&ImId=".$order->trackNum;
     //echo "$url";
     $res = file_get_contents($url);
     $data = json_decode($res,1); 
     if($data['err'] or count($data)<=0)
     {
            return $res;
     }else{
        //очистка полей
        $order->trackNum = null;
        $order->barCode = null;
        $order->save();
     }

     return  ($res);
    }
    
    function addParcel($orderId){
        $order = new Order($orderId);
        $order->user->load();
        $SDATA = prepareData($order);       
        $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, genBaseUrl(null));
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_POSTFIELDS, array(
         'token'=>getToken(),
         'method'=>'ParselCreate',
         'sdata'=>json_encode($SDATA)
         ));
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         //echo json_encode($SDATA)."\n";
         $res = curl_exec($ch);
         
         $data = json_decode($res,1);
         if($data['err'] or count($data)<=0)
         {
            return $res;
         }
         else{
             //r_dump($order);
              $order->trackNum = $data['track'];
              $order->barCode = $data['label'];  
              $order->save();
         }
         return $res;
         /*
           success response
         {"track":"PHP1431718","label":"http:\/\/test.api.boxberry.de\/?act=build&track=PHP1431718&token=10000.rbpqbafb"}
         */
        
    }
    
    function prepareData($order){
         $SDATA=array();
         if ($order->trackNum!=null){
            $SDATA['updateByTrack']=$order->trackNum;
         }
         $di = new DeliveryInfo($order->adres);
         $SDATA['order_id']=$order->id;
         //$SDATA['barcode']='Штрих-код заказа';
         $SDATA['price']=$order->totalSum;
         $SDATA['payment_sum']=$order->totalSum+$di->deliveryPrice;
         $SDATA['delivery_sum']=$di->deliveryPrice;
             $custName = '';
             $phone = '';
             $email = '';
             $address = '';
             //var_dump($order);
             if ($order->user->login==null){
                 $custName = $order->firstName;
                 $phone = $order->tel;
                 $email = $order->email;
             }else{
                $custName  = "{$order->user->firstName} {$order->user->lastname}";
                $phone = $order->user->tel;
                $email = $order->user->email;
                $address = $order->user->adres;
             }
             
             $SDATA['customer']=array(
             'fio'=>iconv("windows-1251", "UTF-8", $custName),
             'phone'=>iconv("windows-1251", "UTF-8", $phone),
             'email'=>iconv("windows-1251", "UTF-8", $email),
             'address'=>iconv("windows-1251", "UTF-8", $address)

             );         
         if ($di->method==2){
             $SDATA['vid']=1;
            $SDATA['shop']=array(
             'name'=>$di->pvzId,
             'name1'=>$GLOBALS[_PVZ_BB]
             );

         }if ($di->method==3){
             $SDATA['vid']=2;
            $SDATA['shop']=array(
             //'name'=>77571,
             'name1'=>$GLOBALS[_PVZ_BB]
             );             
             $SDATA['kurdost'] = array(
             'index' => intval($di->index),
             'citi' =>iconv("windows-1251", "UTF-8",  $di->city),
             'addressp' => iconv("windows-1251", "UTF-8", $di->address),
             //'timesfrom1' => 'Время доставки, от',
             //'timesto1' => 'Время доставки, до',
             //'timesfrom2' => 'Альтернативное время, от',
             //'timesto2' => 'Альтернативное время, до',
             //'timep' => 'Время доставки текстовый формат',
             'comentk' => $order->description
             );                                     
         }
          $SDATA['customer']['address'] = $SDATA['kurdost']['addressp'];

         
         
         $dicount = $order->discount;
         $nds = 18;
         $price = $goodsOne->goodsprice;
         if ($dicount!=0){
            $price = $price- ($price*$dicount)/100;     
         }
         
         //$ndsVal = ($price*$nds)/100;
         $ndsVal = 0;

         $SDATA['items']=array();
         $SDATA['weights']=array( );
         $unitName = iconv("windows-1251", "UTF-8", 'шт');
         foreach($order->child as $item){
             $goodsOne = new Goods($item->goodsId); 
             $price = $item->goodsprice;
             if ($dicount!=0){
                $price = $price- ($price*$dicount)/100;     
             }
             
             //$ndsVal = ($price*$nds)/100;
             $ndsVal = 0;    

             $gd = array(
                     'id'=>$item->goodsId,
                     'name'=>iconv("windows-1251", "UTF-8", $goodsOne->name),
                     'UnitName'=>$unitName,
                     'nds'=>$ndsVal,
                     'price'=>$price,
                     'quantity'=>$item->cnt
                 );
             array_push($SDATA['items'], $gd);

             //array_push($SDATA['weights'], 100);
             $SDATA['weights']['weight'] = $goodsOne->getWeight()*$item->cnt;
         }
         
         return $SDATA;      
    }
    
    function genBaseUrl($func){
        //return "http://127.0.0.1/cms/bb_emul.php?token=".getToken()."&method=$func";
        //return "http://api.boxberry.de/json.php?token=".getToken()."&method=$func";
        if ($func!=null){
            return "http://test.api.boxberry.de/json.php?token=".getToken()."&method=$func";
        }else{
            return "http://test.api.boxberry.de/json.php";
        }
        
    }
    
    function getToken(){
        //return "24349.rrpqdafe";   
        return $GLOBALS[_BB_TOKEN];
    }
    
    
?>