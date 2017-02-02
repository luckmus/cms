<?php

class CartView{
     private $cart;
    function CartView($cart){
        $this->cart = $cart;
    }
    
    public function getView(){
        $res = "� ������� {$this->cart->itemsCount()} </br>";           
        $res .= "<div style=\"visibility:hidden\" id='apply_card'></div>";   
        $res .="<table class='cart-table'>"; 
         
        $res .="<thead><tr>";  
        $res .="<th>#</th>";
        $res .="<th>������������</th>";
        $res .="<th>����������</th>";
        $res .="<th>����</th>";
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
        $res .="<td><b>�����:</b></td>";
        $res .="<td></td><td></td>";
        $res .="<td><b>$summ {$GLOBALS[_CURRENCY]}</b></td>";
        $dis = ($c>0)?"":"disabled";
        
        $res .="</tr>";
        $res .="<tr>";
        $res .="<td><span id='promo_text' class='promo_line'></span></td>";
        $res .="<td><span id='promo_value' class='promo_line'></span></td>";
        $res .="<td></td>";      
        $res .="<td><span id='summ_with_promo' class='promo_line'></span></td>";
        $res .="</tr>";     ;                                                                          
        $res .= "</tfoot>";        
        $res .="</table>"; 
        $res .= "</br>";
        $res .="<input type='checkbox' id='promo_check' 
        onChange=\" $('#promo').css('visibility', this.checked?'visible':'hidden');\">
        <label for='promo_check' style=\"cursor: pointer\" >� ���� ���� �����-���</label>";
        $res .= "<span id='promo' style=\"visibility: hidden\">";
        $res .="<input type='text' id='promo_id' size=10>";
        $res .="<button onClick=\"  console.log($('#promo_id').val()); applyPromo($('#promo_id').val());\">��������� �����-���</button>";
        $res .= "</span>";
        $res .= "</br>";
        $res .= "����������� �����";    
        $res .= " <font color=\"red\">*</font><input type=\"text\" name=\"rcontrdig$id\" id=\"rcontrdig$id\" size=\"4\" maxlength=\"4\"></input>";
        $cntrlDig = GetHost()."/controldig.php";
        $cntrldgId = "cntrldg$id";
        $res .= " <img src=\"$cntrlDig\" id=\"$cntrldgId\"></img><span onclick=\"refreshControlDig('$cntrldgId')\" style=\"cursor:pointer\">��������</span>";
        $res .= "</br>";
        $res .= "</br>";
        $res .="<button $dis onClick=\"showAddOrderFE_cart('apply_card',null,null,'{$_SESSION[_LOGIN_ID]}', true,  $('#promo_id').val());\">��������</button>";
        $res .="<input type='hidden' id='promo_name_hidden'>";
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
        $res .= "<td><a title='������� ����� �� �������' href='#' onClick=\" if (confirm('������� ����� �� �������?')){removeFromCart({$this->item->goods->id});}\"><img src='icons/trash.gif'/></a></td>";                                       
        $res .= "</tr>";
        return $res;             
    }
}

?>