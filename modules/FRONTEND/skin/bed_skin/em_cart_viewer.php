<?php

class CartView{
     private $cart;
    function CartView($cart){
        $this->cart = $cart;
    }
    
    public function getView(){
        $res = "В корзине {$this->cart->itemsCount()} </br>";           
        $res .= "<div style=\"visibility:hidden\" id='apply_card'></div>";   
        $res .="<table class='cart-table'>"; 
         
        $res .="<thead><tr>";  
        $res .="<th>#</th>";
        $res .="<th>Наименование</th>";
        $res .="<th>Количество</th>";
        $res .="<th>Цена</th>";
        $res .="<th></th>";
        $res .="</tr></thead>"; 
        $res .="<tbody>";  
        $summ = 0;
        $c = 0;
        foreach($this->cart->list as $item){
                                        
            $itemView = new CartItemView($item);
            $res .= $itemView->getView();
            $summ +=  $item->price*$item->cnt;
            $c += $item->cnt;
        }
        
        $res .="</tbody>";  
        $res .= "<tfoot>";
        $res .="<tr>";
        $res .="<td>Итого:</td>";
        $res .="<td><b>$summ {$GLOBALS[_CURRENCY]}</b></td>";
        $dis = ($c>0)?"":"disabled";
        $res .="<td><button $dis onClick=\"showAddOrderFE_cart('apply_card',null,null,'{$_SESSION[_LOGIN_ID]}', true,  $('#promo_id').val());\">Оформить</button></td>";
        $res .="</tr>";
        $res .="<tr>";
        $res .="<td></td>";
        $res .="<td><input type='checkbox' id='promo_check' 
        onChange=\" $('#promo_id').css('visibility', this.checked?'visible':'hidden');\">
        <label for='promo_check' style=\"cursor: pointer\" >У меня есть промо-код</label></td>";
        $res .="<td><input type='text' id='promo_id' size=10 style=\"visibility: hidden\"></td>";
        $res .="</tr>";
        $res .= "</tfoot>";        
        $res .="</table>";  
        return $res; 
    }

    
}

class CartItemView{
    public $item;
    public $num;
    public static $counter = 0;
    
    function CartItemView($item){
        $this->item = $item;   
        $this->num = ++CartItemView::$counter;
    }
    
    public function getView(){
        $res = "";
        $res .= "<tr>";                 
        $res .= "<td>{$this->num}</td>";   
        $res .= "<td><a href='?show=goodsone&id={$this->item->goods->id}'>{$this->item->goods->name}</a></td>";   
        $res .= "<td><a href='#' onClick=\"cartMinusGoods({$this->item->goods->id});\"><img src='icons/minus.png'></a>&nbsp;&nbsp;{$this->item->cnt}&nbsp;&nbsp;<a href='#' onClick=\"cartPlusGoods({$this->item->goods->id});\"><img src='icons/add.ico'></a></td>";   
        $totalForGoods = $this->item->price*$this->item->cnt;
        $res .= "<td>$totalForGoods</td>";   
        $res .= "<td><a title='Удалить товар из корзины' href='#' onClick=\" if (confirm('Удалить товар из корзины?')){removeFromCart({$this->item->goods->id});}\"><img src='icons/trash.gif'/></a></td>";                                       
        $res .= "</tr>";
        return $res;             
    }
}

?>