<?php
class ClOrderView{
    public $order;
    public $error;
    public $token;
    public $extPayed = false;
    function ClOrderView($id, $token){
        if ($id == null){
            $this->error = "Номер заказа не передан";
            return;
        }
        
        $this->order = new Order($id);
        
        if (!$this->order->isParent() ){
            $this->error = "Заказ не найден";
            return;
        }
        if ($this->order->token != $token){
            $this->error = "Неверный токен заказа";
            return;
        }
    }  
    
    public function getView(){
        if ($this->error!=null){
            return $this->error;
        }
        $res = '';
        $res .= "<div><h1>Заказ № {$this->order->id}<h1></div>";
        $name = "";
        $phone = "";
        $email = "";
        if ($this->order->user->login != null){
            $name = $this->order->user->firstName;
            $phone = $this->order->user->tel;
            $email = $this->order->user->email;
        }else{
            $name = $this->order->firstName;
            $phone = $this->order->tel;
            $email = $this->order->email;
        }
        $di = new DeliveryInfo($this->order->adres); 
        $paySum =  round($this->order->totalSum+$di->deliveryPrice, 2);
         $payed =  $this->order->payAmount;
        $res .= "      
        <div class='div-table'>
             <div class='div-table-row'>
                <div  class='div-table-col'>ФИО:</div>
                <div  class='div-table-col'>{$name}</div>
             </div>
            <div class='div-table-row'>
                <div class='div-table-col' >Телефон:</div>
                <div  class='div-table-col'>$phone</div>
             </div>
            <div class='div-table-row'>
                <div class='div-table-col' >email:</div>
                <div  class='div-table-col'>$email</div>
             </div>
             
             <div class='div-table-row'>
                <div class='div-table-col' >Сумма к оплате:</div>
                <div  class='div-table-col'>{$paySum}&nbsp;{$GLOBALS[_CURRENCY]}</div>
             </div>";
             $paymetnInfo = "";
             if (($this->extPayed == true) && ($payed==0)){
                  $paymetnInfo = "Если Вы попали на эту страницу, то скорее всего Ваш заказ оплачен, но мы еще не получили подтверждение от банка.<br/><br/>
                  Как правило, оно приходит в течении нескольких минут. Просто наберитесь терпения и перезагрузите страницу через некоторое время.<br/><br/>
                  Если Вы продолжаете видеть данное сообщение, спустя несколько минут после оплаты,то свяжитесь с нами по телефону указанному в разделе Контакты, и мы обязательно Вам поможем.";
             }else{
                 $paymetnInfo = "{$payed}&nbsp;{$GLOBALS[_CURRENCY]}"; 
             }
             $res .= "
                 <div class='div-table-row'>
                    <div class='div-table-col' ><b>Оплачено:</b></div>
                    <div  class='div-table-col'><b>$paymetnInfo</b></div>
                 </div>";             
             if (($payed==0) && !($this->order->isPassedToDelivery()) && ($this->extPayed == false)){
                $res .= "
                 <div class='div-table-row'>
                    <div class='div-table-col' ><b>Ссылка на оплату:</b><br/>При оплате заказа через сайт, Вам будет предоставленна дополнительная скидка в размере <b>{$GLOBALS[_EMONEY_DISCOUNT]}%</b></div>
                    <div  class='div-table-col'><b><a href='{$this->order->getPaymentURL()}'>Оплатить</a></b></div>
                 </div>";
             }
             
             $res .= "
              <div class='div-table-row'>
                        <div class='div-table-col' >&nbsp;</div>
                        <div class='div-table-col' >&nbsp;</div>
             </div>
             <div class='div-table-row'>
                <div class='div-table-col' >Доставка:</div>
                <div  class='div-table-col'><b>{$this->getDeliveryName($di->method)}</b></div>
             </div>      
             ".$this->getDeliveryInfo($di, $this->order->trackNum)."
      </div> ";
        
        return $res;
    }
    
    private function getDeliveryName($method){
        switch($method){
            case 1: return "Самовывоз";
            case 2: return "До пункта выдачи BoxBerry";
            case 3: return "Курьерская доставка службой BoxBerry";
            default: return "Не известно";
        }
    }
     private function getDeliveryInfo($info, $trackNum){
        switch($info->method){
            case 1: return "";
            case 2: return $this->getDeliveryInfoPVZ($info, $trackNum);
            case 3: return $this->getDeliveryInfoCur($info, $trackNum);
            default: return "Не известно";
        }
    }
    private function getDeliveryInfoPVZ($info, $trackNum){
            
        $res = "
            <div class='div-table-row'>
                <div class='div-table-col' >Адрес ПВЗ:</div>
                <div  class='div-table-col'>{$info->address}</div>
             </div>
             <div class='div-table-row'>
                <div class='div-table-col' >Номер ПВЗ:</div>
                <div  class='div-table-col'>{$info->pvzId}</div>
             </div>
             <div class='div-table-row'>
                <div class='div-table-col' >Телефон:</div>
                <div  class='div-table-col'>{$info->phone}</div>
             </div>
             <div class='div-table-row'>
                <div class='div-table-col' >График работы:</div>
                <div  class='div-table-col'>{$info->workSchedule}</div>
             </div>
             <div class='div-table-row'>
                <div class='div-table-col' >Телефон:</div>
                <div  class='div-table-col'>{$info->phone}</div>
             </div>
             
             ";
             if ($trackNum!=null){
                  $res .= "<div class='div-table-row'>
                <div class='div-table-col' >Трековый номер:</div>
                <div  class='div-table-col'><b>{$trackNum}</b> <a href='http://boxberry.ru/' target='blank'>Отследить</a></div>
             </div>";
             } else{
                 $res .= "<div class='div-table-row'>
                <div class='div-table-col' >Статус:</div>
                <div  class='div-table-col'><b>Ожидает передачу в службу доставки<b></div>
             </div>";
             }
             return $res;
    }
    private function getDeliveryInfoCur($info, $trackNum){

        $res = "
            <div class='div-table-row'>
                <div class='div-table-col' >Адрес доставки:</div>
                <div  class='div-table-col'>{$info->index}, {$info->city}, {$info->address}</div>
             </div>
             ";
             if ($trackNum!=null){
                  $res .= "<div class='div-table-row'>
                <div class='div-table-col' >Трековый номер:</div>
                <div  class='div-table-col'><b>{$trackNum}</b> <a href='http://boxberry.ru/' target='blank'>Отследить</a></div>
             </div>";
             } else{
                 $res .= "<div class='div-table-row'>
                <div class='div-table-col' >Статус:</div>
                <div  class='div-table-col'><b>Ожидает передачу в службу доставки<b></div>
             </div>";
             }
             return $res;
    }
}    
?>