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
        $res .="<td><b>Итого:</b></td>";
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
        <label for='promo_check' style=\"cursor: pointer\" >У меня есть промо-код</label>";
        $res .= "<span id='promo' style=\"visibility: hidden\">";
        $res .="<input type='text' id='promo_id' size=10>";
        $res .="<button onClick=\"  console.log($('#promo_id').val()); applyPromo($('#promo_id').val());\">Применить промо-код</button>";
        $res .= "</span>";
        $res .= "</br>";
        /*
        $res .= "Контрольное число";    
        $res .= " <font color=\"red\">*</font><input type=\"text\" name=\"rcontrdig$id\" id=\"rcontrdig$id\" size=\"4\" maxlength=\"4\"></input>";
        $cntrlDig = GetHost()."/controldig.php";
        $cntrldgId = "cntrldg$id";
        $res .= " <img src=\"$cntrlDig\" id=\"$cntrldgId\"></img><span onclick=\"refreshControlDig('$cntrldgId')\" style=\"cursor:pointer\">Обновить</span>";
        $res .= "</br>";
        */
        $res .= "</br>";
    
    $id = "postfix";
    $descrCode = "<table>";
    
    $descrCode .= "<tr>";
    
    $descrCode .= "<td>";
    $descrCode .= "Контрольное число:<font color=\"red\">*</font>";
    $descrCode .= "</td>";
    
    $descrCode .= "<td>";
    $descrCode .= "<input type=\"text\" name=\"rcontrdig$id\" id=\"rcontrdig$id\" size=\"4\" maxlength=\"4\"></input>";
    $cntrlDig = GetHost()."/controldig.php";
    $cntrldgId = "cntrldg$id";
    $descrCode .= " <img src=\"$cntrlDig\" id=\"$cntrldgId\"></img><span onclick=\"refreshControlDig('$cntrldgId')\" style=\"cursor:pointer\">Обновить</span>";
    $descrCode .= "</td>";
    
    $descrCode .= "</tr>";
    
    $descrCode .= "<tr>";
    
    $descrCode .= "<td>";
    $descrCode .= "Примечание:";
    $descrCode .= "</td>";
    
    $descrCode .= "<td>";
    $descrCode .= "<textarea name=\"descr\" id=\"descrid$id\" class=\"address_elem\" rows=\"4\" cols=\"30\" >$descr</textarea>";
    $descrCode .= "</td>";
    
    $descrCode .= "</tr>";
    $msgText = "";
    $userId = $_SESSION[_LOGIN_ID];
    if ($userId==null){
 
        $msgText .= "<tr>";
        
        $msgText .= "<td>";
        $msgText .= "Имя:";
        $msgText .= "</td>";
        
        $msgText .= "<td>";
        $msgText .= "<input id=\"firstnameid$id\" name=\"firstname\" value=\"$firstname\"  size=\"33\" class=\"inputtext\" type=\"text\"></input>";
        $msgText .= "</td>";
        
        $msgText .= "</tr>";
        
        $msgText .= "<tr>";
        
        $msgText .= "<td>";
        $msgText .= "Фамилия:";
        $msgText .= "</td>";
        
        $msgText .= "<td>";
        $msgText .= "<input id=\"lastеnameid$id\" name=\"lastname\" value=\"$lastname\"  size=\"33\"  class=\"inputtext\" type=\"text\"></input>";
        $msgText .= "</td>";
        
        $msgText .= "</tr>";
        
        $msgText .= "<tr>";
        
        $msgText .= "<td>";
        $msgText .= "Телефон:<font color='red'>*</font>";
        $msgText .= "</td>";
        
        $msgText .= "<td>";
        $msgText .= "<input id=\"telid$id\" name=\"tel\"  value=\"$tel\"  size=\"33\" class=\"inputtext\" type=\"text\"></input>";
        $msgText .= "</td>";
        
        $msgText .= "</tr>";
        
        $msgText .= "<tr>";
        
        $msgText .= "<td>";
        $msgText .= "e-mail:";
        $msgText .= "</td>";
        
        $msgText .= "<td>";
        $msgText .= "<input id=\"emailid$id\" name=\"email\" value=\"$email\" size=\"33\" class=\"inputtext\" type=\"text\"></input>";
        $msgText .= "</td>";
        
        $msgText .= "</tr>";
        
        $msgText .= "<tr>";
        
        $msgText .= "<td>";
        $msgText .= "Адрес:";
        $msgText .= "</td>";
        
        $msgText .= "<td>";
        $msgText .= "<textarea name=\"adres\" id=\"adresid$id\" class=\"address_elem\" rows=\"4\" cols=\"30\">$adres</textarea>";
        $msgText .= "</td>";
        
        $msgText .= "</tr>";
 
    }
    
    $descrCode .= $msgText;    
    $descrCode .= "</table>";
    $descrCode .= "<br>";
    $res .= $descrCode;
        //$res .="<button $dis onClick=\"showAddOrderFE_cart('apply_card',null,null,'{$_SESSION[_LOGIN_ID]}', true,  $('#promo_id').val());\">Оформить</button>";
        $res .="<button $dis onClick=\"showAddOrderBE(null, null,'$id','{$_SESSION[_LOGIN_ID]}', true,  $('#promo_id').val());\">Оформить</button>";
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
        $res .= "<td><a title='Удалить товар из корзины' href='#' onClick=\" if (confirm('Удалить товар из корзины?')){removeFromCart({$this->item->goods->id});}\"><img src='icons/trash.gif'/></a></td>";                                       
        $res .= "</tr>";
        return $res;             
    }
}

?>