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
        $res .="<div class='apply_promo'>";
        $res .= "<input type='hidden' value='$summ' id='paymentSum'>";
        $res .="<input type='checkbox' id='promo_check' 
        onChange=\" $('#promo').css('visibility', this.checked?'visible':'hidden');\">
        <label for='promo_check' style=\"cursor: pointer\" >У меня есть промо-код</label>";
        
        $res .= "<span id='promo' style=\"visibility: hidden\">";
        $res .="<input type='text' id='promo_id' size=10>";
        $res .="<button onClick=\"  console.log($('#promo_id').val()); applyPromo($('#promo_id').val());\">Применить промо-код</button>";
        $res .= "</span>";
        $res .="</div>";
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
    $msgText = "<table>";
    
    $msgText .= "<tr>";
    
    $msgText .= "<td>";
    $msgText .= "Контрольное число:<font color=\"red\">*</font>";
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    $msgText .= "<input type=\"text\" name=\"rcontrdig$id\" id=\"rcontrdig$id\" size=\"4\" maxlength=\"4\"></input>";
    $cntrlDig = GetHost()."/controldig.php";
    $cntrldgId = "cntrldg$id";
    $msgText .= " <img src=\"$cntrlDig\" id=\"$cntrldgId\"></img><span onclick=\"refreshControlDig('$cntrldgId')\" style=\"cursor:pointer\">Обновить</span>";
    $msgText .= "</td>";
    
    $msgText .= "</tr>";
    

    $userId = $_SESSION[_LOGIN_ID];
    if ($userId==null){
 
        $msgText .= "<tr>";
        
        $msgText .= "<td>";
        $msgText .= "Имя (Фамилия):";
        $msgText .= "</td>";
        
        $msgText .= "<td>";
        $msgText .= "<input id=\"firstnameid$id\" name=\"firstname\" value=\"$firstname\"  size=\"33\" class=\"inputtext\" type=\"text\"></input>";
        $msgText .= "</td>";
        
        $msgText .= "</tr>";
/*        
        $msgText .= "<tr>";
        
        $msgText .= "<td>";
        $msgText .= "Фамилия:";
        $msgText .= "</td>";
        
        $msgText .= "<td>";
        $msgText .= "<input id=\"lastеnameid$id\" name=\"lastname\" value=\"$lastname\"  size=\"33\"  class=\"inputtext\" type=\"text\"></input>";
        $msgText .= "</td>";
        
        $msgText .= "</tr>";
*/        
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
/*        
        $msgText .= "<tr>";
        
        $msgText .= "<td>";
        $msgText .= "Адрес:";
        $msgText .= "</td>";
        
        $msgText .= "<td>";
        $msgText .= "<textarea name=\"adres\" id=\"adresid$id\" class=\"address_elem\" rows=\"4\" cols=\"30\">$adres</textarea>";
        $msgText .= "</td>";
        
        $msgText .= "</tr>";
  */
    }
    
    $msgText .= "<tr>";
    
    $msgText .= "<td>";
    $msgText .= "Примечание:";
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    $msgText .= "<textarea name=\"descr\" id=\"descrid$id\" class=\"address_elem\" rows=\"4\" cols=\"30\" >$descr</textarea>";
    $msgText .= "</td>";
    
    $msgText .= "</tr>";
        
    $msgText .= "</table>";
    
    $msgText .= "<fieldset style=\"width:100%;\">
  <legend>Доставка</legend>
  <div id='select_delivery_panel'>
  <input type='radio' name='delivery' value='1' id='self_del' onChange=\"selectDelivery();\"> <label for='self_del' style=\"cursor: pointer\" >Самовывоз со склада в Санкт-Петербург</label><br>
  <div id='self_descr' class='self_del_desc'>Осуществляется в рабочие дни <b>с 10:00 до 20:00</b> по адресу: <b>Кондратьвский пр. д62 корп. 6</b>. Обязательное предварительное согласование.</div>
  <input type='radio' name='delivery' value='2' id='cur_del'onChange=\"selectDelivery();\"> <label for='cur_del' style=\"cursor: pointer\" >До пункта самовывоза BoxBerry</label><br>  
  <div id='cur_descr' class='cur_del_desc'>
       {$this->getDeliveryMethodBoxBerry(1000)}
    
    <div id='delivery_places'></div> 
  </div>
  <input type='radio' name='delivery' value='3' id='bb_del' onChange=\"selectDelivery();\"> <label for='bb_del' style=\"cursor: pointer\" >Курьерской службой</label><br>  
  {$this->getDeliveryMethodBoxBerryCur(1000)}
  </div>
  <div id='selected_delivery_method_panel'></div>
</fieldset> 
<input type='hidden' id='selected_delivery_method'>
";

    $msgText .= "<br>";
    $res .= $msgText;
        //$res .="<button $dis onClick=\"showAddOrderFE_cart('apply_card',null,null,'{$_SESSION[_LOGIN_ID]}', true,  $('#promo_id').val());\">Оформить</button>";
        $res .="<button $dis onClick=\"showAddOrderBE(null, null,'$id','{$_SESSION[_LOGIN_ID]}', true,  $('#promo_id').val());\">Оформить</button>";
        $res .="<input type='hidden' id='promo_name_hidden'>";
        return $res; 
    }
    
    private function getDeliveryMethodb2cl(){
     return "  <span class='delivery_firel_descr'>Индекс или название города куда надо осуществить доставку</span><br>
        <input type='text' id='delivery_index'><button onClick=\"getDeliveryPosobility($('#delivery_index').val(), 100, 200)\">Проверить</button >";   

    }
    
    private function getDeliveryMethodBoxBerry($weight){
     return "<a href=\"#\" onclick=\" boxberry.open(widjetCallback, 'm2FltAKjbXQBLa2xqZ4sPQ==', 'Санкт-Петербург', '',$('#paymentSum').val(), $weight, $('#paymentSum').val(),0,0,0  ); return false;\">Выбрать пункт выдачи на карте</a>";   

    }
    
    private function getDeliveryMethodBoxBerryCur($weight){
     return "<div id='bb_descr' class='cur_del_desc'> 
        <span class='delivery_firel_descr'>Индекс города куда надо осуществить доставку</span><br>
        <input type='text' id='bb_delivery_index'><button onClick=\"getBBPoints($('#bb_delivery_index').val(),  $('#paymentSum').val(), $weight)\">Проверить</button >
        <div id='bb_curier_info' class='cur_del_desc'>
            <table>
                <tr><td class='delivery_item'>Стоимость достаки:<td><td><span id='bb_cur_del_price'></span><td></tr>
                <tr><td class='delivery_item'>Срок доставки (дней):<td><td><span id='bb_cur_del_period'></span><td></tr>
            </table>
            <a id='sel_cur_del' onClick='selectDeleveryMethod(3, null)'>Доставить курьером</a>
        </div>  
  </div>";   

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