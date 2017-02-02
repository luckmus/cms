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

        function Order($id){
            if ($id!=null){
                $this->id = $id;
                $this->load();
            }
        }
        
        private function load(){
            $query = "SELECT id, goodsid, name, firstname, lastname,  date, tel, email, adres, iscomlete, datecomplete, description, managerdesc, goodsprice, userId, id_parent, (select count(*) from em_order where id_parent={$this->id}), cnt, totalsum, discount FROM em_order WHERE id={$this->id}";    
            $res = mQuery($query);
            if ($row = mysql_fetch_row($res)){
                $this->goodsId      =  $row[1];
                $this->name         =  $row[2];
                $this->firstname    =  $row[3];
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
                
            }
            else{
                $this->id = null;
                return false;
            }
        }
        
        private function loadChild(){
            $query = "SELECT id FROM em_order WHERE id_parent={$this->id}";    
            $res = mQuery($query);
            while ($row = mysql_fetch_row($res)){
                $order = new Order($row[0]);
                $this->child.push($order);
                
            }                          
        }
        
        public function  setUser($id){
            $this->user = new Account($id);
        }
        
        public function save(){
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
            /*
            UserCommunication::init();
            $userMail = $this->geuUserMail();
            UserCommunication::sendMailToManager("Новый заказ", "На сайте ".GetHost()." совершен новый заказ №".$this->id);
            
            if ($userMail!=null){
                UserCommunication::sendMailFmooManager($userMail,"Заказ на сайте "._title, $this->generateMailMsg());    
            }
            */
            
        }
        
        public function generateMailMsg(){
            if (($this->child!=null) && (count($this->cnt)>0)){
                $res =  "На сайте "._title." вы заказали:";
                $i = 0;
                $sum = 0;
                foreach($this->child as $item){                           
                    $goodsOne = new Goods($item->goodsId);
                    $goodsLink = GetHost()."?show=goodsone&id=".$this->goodsId;  
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
                return "На сайте "._title." вы заказали {$goodsOne->name}. Стоимость заказа: {$this->goodsprice} {$GLOBALS[_CURRENCY]}";   
            }
                
        }
        
        public function geuUserMail(){
            if($this->user->id!=null) {
                $this->user->load();
                return $this->user->email;
            }

            if (($this->email!="") || ($this->email!=null)){
                return $this->email;
            }
            return null;
        }
        private function insert(){            
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
                 \"{$this->user->id}\"
              )";
                 
            $res = mQuery($query);
            $this->id = mysql_insert_id();
            //echo($query. " new id: {$this->id} \n ".mysql_info() ."\n"); 
        }
        
        private function update(){
            $query = 
                "UPDATE em_order
                 SET goodsid = ".($this->goodsId == null ? "null": $this->goodsId->id).",
                 goodsprice = \"".addslashes($this->firstName)."\",
                 firstname = \"".addslashes($this->firstName)."\", 
                 lastname = \"".addslashes($this->lastname)."\", 
                 tel = \"".addslashes($this->tel)."\", 
                 email = \"".addslashes($this->email)."\", 
                 adres = \"".addslashes($this->adres)."\",
                 iscomlete = {$this->iscomlete}, 
                 
                 description = \"".addslashes($this->description)."\"
                 WHERE id = {$this->id}";
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
    
?>
