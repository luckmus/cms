<?php
    class PromoList{
        public $list = array();
        function PromoList(){
            $res = mQuery("SELECT id from em_promo order by name");
            while($row = mysql_fetch_array($res)){
                array_push($this->list, new Promo($row[0]));
            }
        }
        
    }

    class Promo{
        public $id;
        public $name;
        public $descr;
        public $value;
        public $endDate;
        public $minOrderCnt;
        
        function Promo($id){
            if ($id!=null){
                $res = mQuery("SELECT id,name, descr, value, end_date, min_order_cnt FROM em_promo where id = '$id'");   
                if ($row = mysql_fetch_array($res)){
                    $this->id = $row[0];
                    $this->name = $row[1];
                    $this->descr = $row[2];
                    $this->value = $row[3];
                    $this->endDate = $row[4];
                    $this->minOrderCnt = $row[5];
                }
            }
        }
        
        public function save(){
            if (intval($this->minOrderCnt)<=0){
                 $this->minOrderCnt = 1;
            }
            if ($this->id == null)   {
                $this->insert();   
            }
            else{
                $this->update();
            }
        }
        
        public function insert(){
            $res = mQuery("insert into em_promo (name, 
                                                    descr, 
                                                    value, 
                                                    end_date,
                                                    min_order_cnt)
                            values(\"".addslashes($this->name)."\",
                                    \"".addslashes($this->descr)."\",
                                    \"".addslashes($this->value)."\",
                                    \"".addslashes($this->endDate)."\",
                                    ".intval($this->minOrderCnt).")");   
            $this->id = mysql_insert_id();
        }
        
        public function update(){
                $res = mQuery("update em_promo set name =\"".addslashes($this->name)."\", 
                                                    descr = \"".addslashes($this->descr)."\", 
                                                    value = \"".addslashes($this->value)."\", 
                                                    end_date = \"".addslashes($this->endDate)."\",
                                                    min_order_cnt = \"".intval($this->minOrderCnt)."\"
                                                    where id = {$this->id}");
        }
        
        public function remove(){
            $res = mQuery("delete from em_promo where id = {$this->id}");   
            $this->id = null;
        }
        
        public static function getPromoByName($name){
            $res = mQuery("SELECT id,name, descr, value, end_date, min_order_cnt FROM em_promo where upper(name) = upper('$name') and end_date>=CURDATE()");   
                if ($row = mysql_fetch_array($res)){
                    $promo = new Promo(null);
                    $promo->id = $row[0];
                    $promo->name = $row[1];
                    $promo->descr = $row[2];
                    $promo->value = $row[3];
                    $promo->endDate = $row[4];
                    $promo->minOrderCnt = $row[5];
                    return  $promo;
                }          
                return null;
        }
        
    }
?>