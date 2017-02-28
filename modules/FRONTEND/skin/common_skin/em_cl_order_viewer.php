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
        
        
        return $res;
    }
}    
?>