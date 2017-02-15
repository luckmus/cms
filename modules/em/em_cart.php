<?php
class Cart{
        public $list = array();
        
        function  Cart(){
            
            $this->load();
             
        }
        
        private function load(){
            $json = $this->loadCartFromCookie();
            if ($json == ""){
                return;   
            }
            //echo $this->loadCartFromCookie();
            $cart = json_decode($this->loadCartFromCookie());
            foreach($cart as $item){
                $cartItem = new CartItem(new Goods($item->{'id'}), $item->{'count'}, $item->{'price'});
                $this->list[] = $cartItem;
            }
        }
        
        private function loadCartFromCookie(){
            foreach($_COOKIE as $cook){
                if (substr($cook, 0,5) == 'cart_'){
                    return substr($cook, 5);
                }
            }
            return "";
        }
        
        public function getTotal(){
            $total = 0;
            foreach($this->list as $item){
                $total += $item->cnt*$item->price;
            }
            return $total;
        }
        
        public function itemsCount(){
            return count($this->list);   
        }
        
        public function getTotalWeight(){
            $total = 0;
            foreach($this->list as $item){   
                $total += $item->goods->getWeight()*$item->cnt;
            }
            return $total;
        }
        
        public function clearCart(){
            setcookie ("cart","cart",time()-3600,"/");   
        }
        
        public function calcDiscountSum($percent){
            return ($this->getTotal()*$percent)/100;
        }
        
        public function getTotalWithDiscount($percent){
            return ($this->getTotal() - $this->calcDiscountSum($percent));
        }
}

class CartItem{
 public $goods;
 public $cnt;
 public $price;
 
 function CartItem($goods, $cnt, $price){
    $this->goods = $goods;
    $this->cnt = $cnt;
    $this->price = $price;
 }
    
}

?>