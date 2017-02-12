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
            $SDATA['updateByTrack']='Трекинг-код ранее созданной посылки';
         }
         $SDATA['order_id']=$order->id;
         //$SDATA['barcode']='Штрих-код заказа';
         $SDATA['price']=$order->totalSum;
         $SDATA['payment_sum']=$order->totalSum;
         $SDATA['delivery_sum']='Стоимость доставки';
         $SDATA['vid']='Тип доставки (1/2)';
         $SDATA['shop']=array(
         'name'=>'Код ПВЗ',
         'name1'=>'Код пункта поступления'
         );
         $SDATA['customer']=array(
         'fio'=>'ФИО получателя',
         'phone'=>'Номер телефона',
         'phone2'=>'Доп. номер телефона',
         'email'=>'E-mail для оповещений',
         'name'=>'Наименование организации',
         'address'=>'Адрес',
         'inn'=>'ИНН',
         'kpp'=>'КПП',
         'r_s'=>'Расчетный счет',
         'bank'=>'Наименование банка',
         'kor_s'=>'Кор. счет',
         'bik'=>'БИК'
         );
         $SDATA['kurdost'] = array(
         'index' => 'Индекс',
         'citi' => 'Город',
         'addressp' => 'Адрес получателя',
         'timesfrom1' => 'Время доставки, от',
         'timesto1' => 'Время доставки, до',
         'timesfrom2' => 'Альтернативное время, от',
         'timesto2' => 'Альтернативное время, до',
         'timep' => 'Время доставки текстовый формат',
         'comentk' => 'Комментарий'
         );

         $SDATA['items']=array(
         array(
         'id'=>'ID товара в БД ИМ',
        'name'=>'Наименование товара',
        'UnitName'=>'Единица измерения',
        'nds'=>'Процент НДС',
         'price'=>'Цена товара',
         'quantity'=>'Количество'
         )
         );
         $SDATA['weights']=array(
         'weight'=>'Вес 1-ого места',
         'barcode'=>'Баркод 1-го места',
         'weight2'=>'Вес 2-ого места',
         'barcode2'=>'Баркод 2-го места',
         'weight3'=>'Вес 3-его места',
         'barcode3'=>'Баркод 3-го места',
         'weight4'=>'Вес 4-ого места');
                
    }
    
    function genBaseUrl($func){
        //return "http://127.0.0.1/cms/bb_emul.php?token=".getToken()."&method=$func";
        return "http://api.boxberry.de/json.php?token=".getToken()."&method=$func";
        
    }
    
    function getToken(){
        return "24349.rrpqdafe";   
    }
    
    
?>