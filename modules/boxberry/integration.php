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
         $SDATA['order_id']=$order->id;
         //$SDATA['barcode']='�����-��� ������';
         $SDATA['price']=$order->totalSum;
         $SDATA['payment_sum']=$order->totalSum;
         $SDATA['delivery_sum']='��������� ��������';
         $SDATA['vid']='��� �������� (1/2)';
         $SDATA['shop']=array(
         'name'=>'��� ���',
         'name1'=>'��� ������ �����������'
         );
         $SDATA['customer']=array(
         'fio'=>'��� ����������',
         'phone'=>'����� ��������',
         'phone2'=>'���. ����� ��������',
         'email'=>'E-mail ��� ����������',
         'name'=>'������������ �����������',
         'address'=>'�����',
         'inn'=>'���',
         'kpp'=>'���',
         'r_s'=>'��������� ����',
         'bank'=>'������������ �����',
         'kor_s'=>'���. ����',
         'bik'=>'���'
         );
         $SDATA['kurdost'] = array(
         'index' => '������',
         'citi' => '�����',
         'addressp' => '����� ����������',
         'timesfrom1' => '����� ��������, ��',
         'timesto1' => '����� ��������, ��',
         'timesfrom2' => '�������������� �����, ��',
         'timesto2' => '�������������� �����, ��',
         'timep' => '����� �������� ��������� ������',
         'comentk' => '�����������'
         );

         $SDATA['items']=array(
         array(
         'id'=>'ID ������ � �� ��',
        'name'=>'������������ ������',
        'UnitName'=>'������� ���������',
        'nds'=>'������� ���',
         'price'=>'���� ������',
         'quantity'=>'����������'
         )
         );
         $SDATA['weights']=array(
         'weight'=>'��� 1-��� �����',
         'barcode'=>'������ 1-�� �����',
         'weight2'=>'��� 2-��� �����',
         'barcode2'=>'������ 2-�� �����',
         'weight3'=>'��� 3-��� �����',
         'barcode3'=>'������ 3-�� �����',
         'weight4'=>'��� 4-��� �����');
                
    }
    
    function genBaseUrl($func){
        //return "http://127.0.0.1/cms/bb_emul.php?token=".getToken()."&method=$func";
        return "http://api.boxberry.de/json.php?token=".getToken()."&method=$func";
        
    }
    
    function getToken(){
        return "24349.rrpqdafe";   
    }
    
    
?>