<?php
#модуль описывающий заказы
    class Orders extends UserCommunication{
     private $orders;
     
     function Orders($orderByField){
         $this->orders = Array();
         if ($orderByField==null){
            $query = "SELECT id FROM em_order where id_parent is null order by date";
         }
         else{
             $query = "SELECT id FROM em_order where id_parent is null order by $orderByField";         
         }
         $res = mQuery($query);
         while ($row = mysql_fetch_row($res)){
            $this->orders[count($this->orders)] = new Order($row[0]);
         }
     }    
    }//Orders
    
    class Order{
       public $id;                                                                    
       public $child = array();
       public $goodsId;
       public $user;
       public $name;
       public $firstName; 
       public $lastname;
       public $date;
       public $tel;
       public $email;
       public $adres;
       public $iscomlete;
       public $datecomplete;
       public $description;
       public $managerdesc;
       public $goodsprice;                                     //цена на момент заказа
       public $totalSum = 0;
       public $discount = 0;
       public $cnt;
       private $parent;
       public $trackNum;
       public $barCode;
       public $token;
       public $payResultCode;
       public $payDesc;
       public $payAmount;

        function Order($id){
            if ($id!=null){
                $this->id = $id;
                $this->load();
            }
        }
        
        private function load(){
            $query = "SELECT id, goodsid, name, firstname, lastname,  date, tel, email, adres, iscomlete, datecomplete, description, managerdesc, goodsprice, userId, id_parent, (select count(*) from em_order where id_parent={$this->id}), cnt, totalsum, discount, track_number, bar_code, token, pay_result_code, pay_desc,pay_amount  FROM em_order WHERE id={$this->id}";    
            $res = mQuery($query);
            if ($row = mysql_fetch_row($res)){
                $this->goodsId      =  $row[1];
                $this->name         =  $row[2];
                $this->firstName    =  $row[3];
                $this->lastname     =  $row[4];
                $this->date         =  $row[5];
                $this->tel          =  $row[6];
                $this->email        =  $row[7];
                $this->adres        =  $row[8];
                $this->iscomlete    =  $row[9];
                $this->datecomplete =  $row[10];
                $this->description  =  $row[11];
                $this->managerdesc  =  $row[12];
                $this->goodsprice   =  $row[13];
                $this->user = new Account($row[14]);
                $this->parent = $row[15];
                if ($row[16]>0){
                    $this->loadChild();
                }
                $this->cnt = $row[17];
                $this->totalSum = $row[18]; 
                $this->discount = $row[19]; 
                $this->trackNum = $row[20];
                $this->barCode = $row[21];
                $this->token = $row[22];
                $this->payResultCode = $row[23];    
                $this->payDesc = $row[24];    
                $this->payAmount = $row[25];    
                
            }
            else{
                $this->id = null;
                return false;
            }
        }
        
        public function isPassedToDelivery(){
            return ($this->trackNum != "");
        }
        
        public function getTotalPriceWithEDiscount(){
            if (intval($GLOBALS[_EMONEY_DISCOUNT])>0){
                   return $this->totalSum-($this->totalSum/100)*$GLOBALS[_EMONEY_DISCOUNT];
            }else{
                return   $this->totalSum; 
            }
        }
        
        public function getPaymentURL(){
               $di = new DeliveryInfo($this->adres);
               $delPrice = intval($di->deliveryPrice);
               $payUrl = GetHost()."/?show=";
               $token=$this->token;     
               $delPrice =$this->getTotalPriceWithEDiscount()+$delPrice;
               $URL = "https://moneta.ru/assistant.htm";
               $URL .= "?MNT_ID=".$GLOBALS[_PAW_SHOP_CODE];
               $URL .= "&MNT_TEST_MODE=".$GLOBALS[_PAW_TEST_MODE];
               $URL .= "&MNT_AMOUNT=".$delPrice;
               $URL .= "&MNT_TRANSACTION_ID=".$this->id;

               $URL .= "&MNT_SUCCESS_URL={$payUrl}pay_info_success%26token=$token";
               $URL .= "&MNT_RETURN_URL={$payUrl}pay_info_return%26token=$token";
               $URL .= "&MNT_FAIL_URL={$payUrl}pay_info_fail%26token=$token";
               $URL .= "&MNT_INPROGRESS_URL={$payUrl}pay_info_inpogress%26token=$token";
               
               return $URL;
        }
        
        public function isParent(){
            return $this->parent==null;
        }
        
        public function isPaid(){
            return $this->payResultCode == 200;
            
        }    
        private function loadChild(){
            $query = "SELECT id FROM em_order WHERE id_parent={$this->id}";    
            $res = mQuery($query);
            while ($row = mysql_fetch_row($res)){
                $order = new Order($row[0]);
                array_push($this->child, $order);
                
            }                          
        }
        
        public function  setUser($id){
            $this->user = new Account($id);
        }
        
        public function calcToken(){
            $str = "";
            if ($this->user->login!=null){
                $str .=$this->user->login.$this->user->email.$this->user->tel.$this->user->id;  
            }else{
                $str .= $this->email.$this->tel.$this->firstName.$this->totalSum;
            }
            return md5($str);
        }
        public function save(){
            $isInsert = ($this->id==null);
            if ($this->id == null){
                $this->insert();
                foreach($this->child as $child){
                    $child->parent = $this->id ;
                    $child->insert();
                }
            }
            else{
                $this->update();
            }
            if ($isInsert == true){
                UserCommunication::init();
                $userMail = $this->geuUserMail();
                UserCommunication::sendMailToManager("Новый заказ", "На сайте ".GetHost()." совершен новый заказ №".$this->id);
                
                if ($userMail!=null){
                    UserCommunication::sendMailFmooManager($userMail,"Заказ на сайте "._title, $this->generateMailMsg());    
                }
            
            }
            
        }
        
        public function generateMailMsg(){
            /*
            if (($this->child!=null) && (count($this->cnt)>0)){
                $res =  "На сайте "._title." вы заказали:";
                $i = 0;
                $sum = 0;
                foreach($this->child as $item){                           
                    $goodsOne = new Goods($item->goodsId);
                    $goodsLink = GetHost()."?show=cl_order&id=342&token=c92aa8b39a4af8b3d7a43ff0bf16a826".$this->token;  
                    if ($i>0){
                        $res .= ", ";
                    }
                    $res .= " <a href='$goodsLink'>{$goodsOne->name}</a>";
                    $i++;
                    $sum += $item->goodsprice;
                }
                $res .= " на общую сумму $sum {$GLOBALS[_CURRENCY]}";
                return $res;
            }
            else{
                $goodsOne = new Goods($this->goodsId);
                $goodsLink = GetHost()."?show=goodsone&id=".$this->goodsId;
                return "Вы сделали заказ на нашем сайте: "._title.". Заказ вы можете просмотреть по данной ссылке: $goodsLink . В ближайшее время с Вами свяжется наш менеджер.";   
            }
            */
            $goodsLink = $this->getOrderLink();  
            return "Вы сделали заказ на нашем сайте: "._title.". Заказ вы можете просмотреть по данной ссылке: $goodsLink . В ближайшее время с Вами свяжется наш менеджер.";   
                
        }
        
        public function getOrderLink(){
            $goodsLink = GetHost()."?show=cl_order&id={$this->id}&token=".$this->token;
            return $goodsLink;
        }
        
        public function geuUserMail(){
            if($this->user->id!=null) {
                $this->user->load();
                return $this->user->email;
            }
            /*
            if (($this->email!="") || ($this->email!=null)){
                return $this->email;
            }
            return null;
            */
            return $this->email;
        }
        private function insert(){    
            $t = "";
            if ($this->parent==null){
                $t = $this->calcToken();
                $this->token = $t;
            }
        $query = 
            "INSERT INTO em_order(goodsid,
                               goodsprice,
                               firstname,
                               lastname,
                               tel,
                               email,
                               adres,
                               iscomlete,
                               description,
                               id_parent,
                               cnt,
                               totalsum,
                               discount,
                               token,
                               userId     
                               )
              VALUES(".($this->goodsId == null ? "null": $this->goodsId).",
                 \"".addslashes($this->goodsprice)."\",
                 \"".addslashes($this->firstName)."\", 
                 \"".addslashes($this->lastname)."\", 
                 \"".addslashes($this->tel)."\", 
                 \"".addslashes($this->email)."\", 
                 \"".addslashes($this->adres)."\",
                 {$this->iscomlete}, 
                 \"".addslashes($this->description)."\",
                 ". ($this->parent==null? " NULL ":   addslashes($this->parent)).", 
                 ".addslashes($this->cnt).", 
                 ".addslashes($this->totalSum).", 
                 ".addslashes($this->discount).", 
                 \"$t\",
                 \"{$this->user->id}\"
              )";
                 
            $res = mQuery($query);
            $this->id = mysql_insert_id();
            //echo($query. " new id: {$this->id} \n ".mysql_info() ."\n"); 
        }
        
        private function update(){
            //echo "on update: \n";
            //var_dump($this);
            $query = 
                "UPDATE em_order
                 SET goodsid = ".($this->goodsId == null ? "null": $this->goodsId->id).",
                 goodsprice = \"".addslashes($this->goodsprice)."\",
                 firstname = \"".addslashes($this->firstName)."\", 
                 lastname = \"".addslashes($this->lastname)."\", 
                 tel = \"".addslashes($this->tel)."\", 
                 email = \"".addslashes($this->email)."\", 
                 adres = \"".addslashes($this->adres)."\",
                 iscomlete = {$this->iscomlete}, 
                 
                 description = \"".addslashes($this->description)."\",
                 bar_code = \"".addslashes($this->barCode)."\",
                 track_number = \"".addslashes($this->trackNum)."\",
                 pay_result_code = \"".addslashes($this->payResultCode)."\",
                 pay_desc = \"".addslashes($this->payDesc)."\",
                 pay_amount = \"".addslashes($this->payAmount)."\"
                 WHERE id = {$this->id}";
                 //echo "$query\n";
            $res = mQuery($query);
        }
        
        public function checkForm($rcontrdig)
        {
            $ErrMes = '';
            if ($this->user->id==null){
                if ($this->tel=='')
                    $ErrMes .= 'Телефон не указан. ';
                if ($this->email!=''){
                    if (!preg_match("|^([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|is", strtolower($this->email)))
                    {
                        $ErrMes .= 'Указан некорректный email. ';
                    }
                }
                if (trim($this->firstName)=='')
                    $ErrMes .= 'Имя/фамилия не указаны. ';
            }
                                                    
            if ($ErrMes=='')   
            {
                if ($_SESSION['contrdig']=='')
                    $ErrMes = 'Контрольное число не указано';
                else        
                if ($_SESSION['contrdig']!=$rcontrdig)
                    $ErrMes = 'Неверное контрольное число';
            }
            return $ErrMes;
        }

    }//Order

class DeliveryInfo{
    public $method;
    public $address;
    public $index;
    public $city;
    public $deliveryPrice;
    public $period;
    public $workSchedule;
    public $phone;
    public $prepaid; 
    public $pvzId;
    
    function DeliveryInfo($info){
         $infoDec = iconv("windows-1251", "UTF-8", $info);
         $infoDec = json_decode(htmlspecialchars_decode($infoDec));
         $this->method =  $infoDec->method;
         switch($this->method){
             case 2:
                $this->address = iconv("UTF-8", "windows-1251", $infoDec->pvzId->address);
                $this->phone = $infoDec->pvzId->phone;
                $this->workSchedule = iconv("UTF-8", "windows-1251", $infoDec->pvzId->workschedule);
                $this->prepaid = $infoDec->pvzId->prepaid;
                $this->period = $infoDec->pvzId->period;
                $this->deliveryPrice =$infoDec->pvzId->price ;
                $this->pvzId = $infoDec->pvzId->id;
             break;
             case 3:
                $this->address =iconv("UTF-8", "windows-1251", $infoDec->address) ;
                $this->index = $infoDec->index;
                $this->city = iconv("UTF-8", "windows-1251", $infoDec->city);
                $this->period = $infoDec->curr->delivery_period;
                $this->deliveryPrice =$infoDec->curr->price ;
             break;
             default:
                $this->deliveryPrice=0;
             break;
         }
    } 
    
    
}    

?>
