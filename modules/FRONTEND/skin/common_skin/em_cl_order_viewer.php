<?php
class ClOrderView{
    public $order;
    public $error;
    function ClOrderView($id, $token){
        if ($id == null){
            $this->error = "����� ������ �� �������";
            return;
        }
        
        $this->order = new Order($id);
        
        if (!$this->order->isParent() ){
            $this->error = "����� �� ������";
            return;
        }
        if ($this->order->token != $token){
            $this->error = "�������� ����� ������";
            return;
        }
    }  
    
    public function getView(){
        if ($this->error!=null){
            return $this->error;
        }
        $res = '';
        $res .= "<div><h1>����� � {$this->order->id}<h1></div>";
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
        $res .= "      
        <div class='div-table'>
             <div class='div-table-row'>
                <div  class='div-table-col'>���:</div>
                <div  class='div-table-col'>{$name}</div>
             </div>
            <div class='div-table-row'>
                <div class='div-table-col' >�������:</div>
                <div  class='div-table-col'>$phone</div>
             </div>
            <div class='div-table-row'>
                <div class='div-table-col' >email:</div>
                <div  class='div-table-col'>$email</div>
             </div>
             
             <div class='div-table-row'>
                <div class='div-table-col' >����� � ������:</div>
                <div  class='div-table-col'>{$paySum}&nbsp;{$GLOBALS[_CURRENCY]}</div>
             </div>
              <div class='div-table-row'>
                        <div class='div-table-col' >&nbsp;</div>
                        <div class='div-table-col' >&nbsp;</div>
             </div>
             <div class='div-table-row'>
                <div class='div-table-col' >��������:</div>
                <div  class='div-table-col'><b>{$this->getDeliveryName($di->method)}</b></div>
             </div>      
             ".$this->getDeliveryInfo($di, $this->order->trackNum)."
      </div> ";
        
        return $res;
    }
    
    private function getDeliveryName($method){
        switch($method){
            case 1: return "���������";
            case 2: return "�� ������ ������ BoxBerry";
            case 3: return "���������� �������� ������� BoxBerry";
            default: return "�� ��������";
        }
    }
     private function getDeliveryInfo($info, $trackNum){
        switch($info->method){
            case 1: return "";
            case 2: return $this->getDeliveryInfoPVZ($info, $trackNum);
            case 3: return $this->getDeliveryInfoCur($info, $trackNum);
            default: return "�� ��������";
        }
    }
    private function getDeliveryInfoPVZ($info, $trackNum){
            
        $res = "
            <div class='div-table-row'>
                <div class='div-table-col' >����� ���:</div>
                <div  class='div-table-col'>{$info->address}</div>
             </div>
             <div class='div-table-row'>
                <div class='div-table-col' >�������:</div>
                <div  class='div-table-col'>{$info->phone}</div>
             </div>
             <div class='div-table-row'>
                <div class='div-table-col' >������ ������:</div>
                <div  class='div-table-col'>{$info->workSchedule}</div>
             </div>
             <div class='div-table-row'>
                <div class='div-table-col' >�������:</div>
                <div  class='div-table-col'>{$info->phone}</div>
             </div>
             
             ";
             if ($trackNum!=null){
                  $res .= "<div class='div-table-row'>
                <div class='div-table-col' >�������� �����:</div>
                <div  class='div-table-col'><b>{$trackNum}</b> <a href='http://boxberry.ru/' target='blank'>���������</a></div>
             </div>";
             } else{
                 $res .= "<div class='div-table-row'>
                <div class='div-table-col' >&nbsp;</div>
                <div  class='div-table-col'>������� �������� � ������ ��������</div>
             </div>";
             }
             return $res;
    }
    private function getDeliveryInfoCur($info, $trackNum){

        $res = "
            <div class='div-table-row'>
                <div class='div-table-col' >����� ��������:</div>
                <div  class='div-table-col'>{$info->index}, {$info->city}, {$info->address}</div>
             </div>
             ";
             if ($trackNum!=null){
                  $res .= "<div class='div-table-row'>
                <div class='div-table-col' >�������� �����:</div>
                <div  class='div-table-col'><b>{$trackNum}</b> <a href='http://boxberry.ru/' target='blank'>���������</a></div>
             </div>";
             } else{
                 $res .= "<div class='div-table-row'>
                <div class='div-table-col' >&nbsp;</div>
                <div  class='div-table-col'>������� �������� � ������ ��������</div>
             </div>";
             }
             return $res;
    }
}    
?>