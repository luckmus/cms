<?php                                                                                                               
   #описывает товар отображаемый в виде постельного бклья
    class GoodsOneView extends Common_goodsone{
        //public $goodsOne;                                                               //объект Goods
        public $goodsNum;                                                               //объект Goods               
        function GoodsOneView($goodsOne,$number){         
            $this->goodsOne = $goodsOne;
            $this->goodsNum = $number;
        }
        private function getLink(){
            return GetHost()."?show=goodsone&id=".$this->goodsOne->id;    
        }
        public function getView(){
            $result = "";    
            $result .= $this->getPlaceForOrderMsg();
            $goodsViewId = "litem_".$this->goodsNum;
            //$goodsViewId = "litem_".$this->goodsOne->id;
            $viewLeft = $this->goodsNum*400;
            $descr = $this->goodsOne->desc;
            $price = $this->getViewPrice();
            $num = $this->goodsNum+551;
//            $this->goodsNum = $this->goodsOne->id;
            $result .= '  
<div style="top: 0px; left: 0px; margin-left: 0px; width: 400px; height: 377px;" class="litem" id="'.$goodsViewId.'">
   <div class="lview">
      <div class="limg">
         <img src="'.$this->goodsOne->imagefile.'" style=" width: 400px; height: 290px;" alt="" id="limg0" />
      </div>
      <div style="top: 337px;" class="netshad">
         <table>
            <tbody>
               <tr>
                  <td>
                     <div class="netname">'.$this->goodsOne->name.'</div>
                  </td>
                  <td>
                     <div class="netprice">'.$price[0].'</div>
                  </td>
               </tr>
            </tbody>
         </table>
         <div class="buy buy_'.$num.'">
            <span class="show_txt_bascket">
               <img style="cursor: pointer;" src="add_files/i_basket.png" alt="" onClick="'.$this->getAddOrderMsgScript().'" />
            </span>
         </div>
         <div class="buy buy_ok_'.$num.'" style="display:none;">
            <span class="show_txt_bascket">
               <img src="add_files/i_basket2.png" alt="" />
            </span>
            <!--<span style="color:#bababa;" >Купить</span>-->
         </div>
      </div>
   </div>
   <div class="mdescr">
      <div class="mdspacer">
         <div class="netname">'.$this->goodsOne->name.'</div>
         <div class="netlogo">
            <a href="'.$this->getLink().'">
               <img src="add_files/item_incard.gif" alt="Подробно" />
            </a>
         </div>
         <br />
         <p>'.$descr.'</p>
         <div class="size_descr" id=".$this->getSizeDesctValueId().">'.$price[2].'</div>
         '.$this->getViewParams().'
         <div class="cfx">
            <div class="belsize">
               <div class="belsname">
                  Выберите
                  <br />
                  размер:
               </div>
               '.$price[1].'
            </div>
         </div>
         <input id="size_card_0" value="35" type="hidden" />
         <div class="mpriceline">
            <div class="netprice" id='.$this->getPriceValueId().'>'.$price[0].'</div>
            <div class="buy buy_'.$num.'">
               <span class="show_txt_bascket">
                  <img style="cursor: pointer;" src="add_files/i_basket.png" alt="" onclick="'.$this->getAddOrderMsgScript().'" />
               </span>
               <a href="#" onClick="'.$this->getAddOrderMsgScript().'">Купить</a>
            </div>
         </div>
         <img src="add_files/b_close.png" alt="" class="mclose" />
      </div>
   </div>
</div>
';
          return $result;  
        }//getView
        private function getAllViewParams(){
            $params = $this->goodsOne->getAllGoodsParam();
            $res = "";
            $res = '<table class="beltth"><tbody>';
            for($i=0; $i<count($params); $i++){
                
                $param = $params[$i][0];
                $param->Load();
                $res .= "<tr>";
                $res .= "<td>{$param->paramName}:</td>";
                $res .= "<td>{$param->parameter->value}</td>";
                //$res .= "<td>{$param->value}</td>";
                
                $res .= "</tr>";
            }
            $res .= '</tbody></table>';
            
            return $res;
        }    
        public function getViewParams(){
            $params = $this->goodsOne->getGoodsParam(1);
            $res = "";
            $res = '<table class="beltth"><tbody>';
            for($i=0; $i<count($params); $i++){
                $param = $params[$i][0];
                $param->Load();
                $res .= "<tr>";
                $res .= "<td>{$param->paramName}:</td>";
                $res .= "<td>{$param->parameter->value}</td>";                
                $res .= "</tr>";
            }
            $params = $this->goodsOne->getGoodsParam(2);
            for($i=0; $i<count($params); $i++){
                $param = $params[$i][0];
                $param->Load();
                $res .= "<tr>";
                $res .= "<td>{$param->paramName}:</td>";
                $res .= "<td>{$param->parameter->value}</td>";                
                $res .= "</tr>";
            }  
            $params = $this->goodsOne->getGoodsParam(5);
            for($i=0; $i<count($params); $i++){
                $param = $params[$i][0];
                $param->Load();
                $res .= "<tr>";
                $res .= "<td>{$param->paramName}:</td>";
                $res .= "<td>{$param->parameter->value}</td>";                
                $res .= "</tr>";
            } 
            $res .= '</tbody></table>';
            
            return $res;
        }           
        private function getViewPrice(){
            
            $params = $this->goodsOne->getGoodsParam(Parameters::$priceParam);  
            $res="";
            $firstPrice = 0;
            for($i=0; $i<count($params); $i++){ 
                $param = $params[$i][0];
                $param->Load();
                if ($i==0){
                    $className = 'card_size  price_select';
                    $firstPrice = $param->value;   
                    $firstDescr = $param->parameter->descr;   
                }
                else{
                    $className = 'card_size'; 
                }  
                $someNum = 35+$i;                             
                $res .= '<div class="'.$className.'" style="font-size:1.5em;" onclick="buySizeApply1(this, '.$this->goodsOne->id.',\''.$param->value.'\',\''.$param->parameter->descr.'\', '.$someNum.','.$this->goodsNum.')">'.$param->parameter->value.'</div>';    
            }
            
            return Array($firstPrice, $res, $firstDescr);            
        }
        
        function getSizeDesctValueId(){
            //return "'price'";
            return "'size_card_descr_{$this->goodsOne->id}'";
        }                
    }//class GoodsOneView
    
    # класс описывает визуальное представление товара
    class GoodsCatalog{
        private $categId;
        
        function GoodsCatalog($categId){                        
            $this->categId = $categId;
        }    
            
        public function getCatalogView(){
            $result = "";
            $goodsList = new GoodsList();
            $goodsList->Load();
            if($this->categId!=null) {
                $allGoodsList = $goodsList->getGoodsByCateg($this->categId);
            } 
            else{
                $allGoodsList = $goodsList->getAllGoods();
            }
            for($i=0;$i<count($allGoodsList); $i++){                
                $goodsOneView = new GoodsOneView($allGoodsList[$i],$i);
                $result .= $goodsOneView->getView();
            }  
            //$goodsOneView = new GoodsOneView($allGoodsList[0],0);
            //$result = $goodsOneView->getView();
            return $result;    
        }        
        
    }
?>
