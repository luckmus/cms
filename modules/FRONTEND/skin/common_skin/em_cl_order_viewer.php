<?php
class ClOrderView{
    public $order;
    public $error;
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
        
        
        return $res;
    }
}    
?>