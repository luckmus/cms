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
            $res = '<li>';
            $price = $this->getViewPrice() ;
            $priceVal = $this->goodsOne->getPrice();
            //var_dump($price);
            $res .= "<a href='{$this->getLink()}'>";
            $res .= "<div class='product_photo'>";
            
            $res .= " <img src='{$this->goodsOne->imagefile}' alt=''   style=' width: 220px; height: 220px;'>";
            $res .= '
           <div class="preview" rel="7466">
              <span>Кликните здесь для <br>просмотра</span>                                                                
           </div>
           <div title="Кликните здесь для просмотра" class="onlyinternet">
           </div>
           </div>';
           $res .= "<h3>{$this->goodsOne->name}</h3>";
           $res .= "<div class='price'>{$priceVal}р. &nbsp;&nbsp;</div>Купить";
           $res .= '</a></li>';
           //addLog($res);
           return $res;
        }         
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
            //var_dump($this->goodsOne);
            $params = $this->goodsOne->getGoodsParam(Parameters::$priceParam);  
            $res="";
            $firstPrice = 0;
            for($i=0; $i<count($params); $i++){ 
                $param = $params[$i][0];
                $param->Load();
                if ($i==0){
                    $className = 'card_size  price_select';
                    $firstPrice = $param->parameter->value;   
                    $firstDescr = $param->parameter->descr;   
                }
                else{
                    $className = 'card_size'; 
                }  
                $someNum = 35+$i;                             
                $res .= '<div class="'.$className.'" style="font-size:1.5em;">'.$param->parameter->value.'</div>';    
            }
            
            return Array($firstPrice, $res, $firstDescr, $firstPrice);            
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
