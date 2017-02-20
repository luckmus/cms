<?php
  class Common_goodsone{
      private static $msgPlace = "add-order-place";
      public $goodsOne;
      
      function  common_goodsone($id){
          $this->goodsOne = new Goods($id);  
          Common_goodsone::$msgPlace .= $id;  
      }

    public function getView(){
        
        $res = '';
         
        $res = "<div>";
        $res .= "<h1>".$this->goodsOne->name."</h1>";                
        $gal =$this->goodsOne->getPhotos();
        if ($gal==null){
            $gal = array();
            array_push($gal, new  GoodsPhoto(null, $this->goodsOne->id, $this->goodsOne->imagefile, 0, ""));
        }
                    $res .= ' 
            <ul class="bxslider">';

            foreach($gal as $photo){
              $res .="<li><img src='{$photo->url}' /></li>";
            }
            $res .='</ul>        

                <script>
            $(".bxslider").bxSlider({
              auto: true,
              autoControls: true
            });
              </script>';
  
        
        //$res .= "<p>";
        //$res .= "<img align='left' style=\" width: 400px; height: 290px; margin: 10px 15px 20px 7px\"  src='{$this->goodsOne->imagefile}'>";
        $res .= $this->goodsOne->desc;
        //$res .= "</p>";
        $res .="</div>";
        $res.=$this->getViewParams( );
        $res .= "<div>";
        $res .= $this->getSelectPrice();
        //$res .= "</div>";
        //$res .= "<div>";
        $res .= $this->getBuyButton();
        $res .= "</div>";        
        //$res .= $this->getPlaceForOrderMsg();
        //http://bxslider.com/examples/auto-show-start-stop-controls
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
            $res .= '</tbody></table>';
            
            return $res;
        }                       
         private function getBuyButton(){
            $res = "<input type='button' value='Заказать' onClick=\"{$this->getAddOrderMsgScript()}\">";
            return $res;
         }
         
         public function getAddOrderMsgScript(){
            //return "addGoodToCart({$this->goodsOne->id}, {$this->getPriceValueId()});  showAddOrderFE_cart('".$this->getDivNameForAddOrderMsg()."',{$this->goodsOne->id},{$this->getPriceValueId()},'{$_SESSION[_LOGIN_ID]}');";
            /*
            return "showBuySelectDlg('".$this->goodsOne->name."',  '".$this->getDivNameForAddOrderMsg()."', addGoodToCart, {$this->goodsOne->id}, {$this->getPriceValueId()},  showAddOrderFE_cart,{$this->goodsOne->id},{$this->getPriceValueId()},'{$_SESSION[_LOGIN_ID]}', false)";
            */
            return "addGoodToCart({$this->goodsOne->id}, {$this->getPriceValueId()})";
         }
         public function getDivNameForAddOrderMsg(){
            return Common_goodsone::$msgPlace.$this->goodsOne->id;
         }                                                                                                                                                
        public function getPlaceForOrderMsg(){
            return "<div style=\"visibility:hidden\" id='".$this->getDivNameForAddOrderMsg()."'></div>";   
        }
        public function getSelectPrice(){
            $res = '<select id='.$this->getPriceValueId().'>';
            $params = $this->goodsOne->getGoodsParam(Parameters::$priceParam);  
            for($i=0; $i<count($params); $i++){ 
                $param = $params[$i][0];
                $param->Load();
                $res .= "<option value='{$param->value}'>{$param->parameter->value}: {$param->value} {$GLOBALS['currency']}</option>";              
            }
            $res .= '</select>';
            return $res;
        }
        
        function getPriceValueId(){
            //return "'price'";
            return "'netpriceVar_{$this->goodsOne->id}'";
        }
        
        
  }  
  
?>