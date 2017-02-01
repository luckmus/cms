<?php
    //require_once("parameter.php");
    class GoodsList{
        private $list;
        
        function  GoodsList(){
             //$this->Load();
        }
        
        public function getAllGoods(){
            return $this->list;
        }
        public function getGoodsByCateg($viewCatId){
            $query = "SELECT id FROM em_goods WHERE categoryid = '$viewCatId' and isarchivate =0 order by ordinal";
            return $this->getList($query);
        }        
        public function LoadAll(){
            $query = "SELECT id FROM em_goods order by ordinal";
            return $this->getList($query);
        }
        public function Load(){
            $query = "SELECT id FROM em_goods WHERE isarchivate =0 order by ordinal";
            return $this->getList($query);
        } 
        public function LoadArchive(){
            $query = "SELECT id FROM em_goods WHERE isarchivate = 1 order by ordinal";
            return $this->getList($query);
        }               
        
        private function getList($query){
            $this->list = Array();;
            $res = mQuery($query);
            while ($row = mysql_fetch_row($res)){
                
                $goodsOne = new Goods($row[0]);
                $this->list[count($this->list)] = $goodsOne;
            }
            return $this->list;
        }        
        public function add($catId, $name){  
            $ord = $this->getNextOrdinal();
            $query = "INSERT INTO em_goods(categoryId, name, description, ordinal) VALUES($catId,'$name', '', $ord)";
            $res = mQuery($query);
            //$this->Load();
        }
        
        
        public function delete($id){
            for ($i=0; $i<count($this->list); $i++){
                $goodsOne = $this->list[$i];
                if($goodsOne->id==$id){
                    //удалю все параметры
                    $goodsOneParams = $goodsOne->getAllGoodsParam();
                    for ($j=0; $j<count($goodsOneParams); $j++){
                        $param = $goodsOneParams[$j][0];   
                        $param->DeleteGoodsParam(); 
                    }
                    //удалю сам товар
                    $query = "DELETE FROM em_goods WHERE id = {$goodsOne->id}";
                    $res = mQuery($query);
                    //$this->Load(); 
                    return 1;
                }                
            }
            return 0;   
        }
        
        private function getNextOrdinal(){
            $query = "SELECT MAX(ordinal)+1 FROM em_goods";    
            $res = mQuery($query);
            if ($row = mysql_fetch_row($res)){
                return $row[0];
            }
            else{
                return 1;
            }
        }
        
        public function copyGoodsOne($id,$name){
            for ($i=0; $i<count($this->list); $i++){
                $goodsOne = $this->list[$i];
                if($goodsOne->id==$id){
                    $ord                = $this->getNextOrdinal();
                    if (empty($name))
                        $newName            = "copy_".addslashes($goodsOne->name);
                    else
                        $newName = addslashes($name);
                    $newDesc            = addslashes($goodsOne->desc);
                    $newMetadescription = addslashes($goodsOne->metadescription);
                    $newMetakeywords    = addslashes($goodsOne->metakeywords);
                    $query = 
                    "INSERT INTO em_goods(categoryId, 
                    name, 
                    description, 
                    ordinal,
                    imagefile,
                    metadescription,
                    metakeywords)
                    VALUES({$goodsOne->categoryid},
                        \"{$newName}\",
                        \"{$newDesc}\",
                        $ord,
                        \"{$goodsOne->imagefile}\",
                        \"{$newMetadescription}\",
                        \"{$newMetakeywords}\"
                    )"; 
                    
                    $res = mQuery($query);
                    $newId = mysql_insert_id();
                    $newGoosOne = new Goods($newId);
                    //Добавлю все параметры
                    $srcParams = $goodsOne->getAllGoodsParam();
                    for ($i=0; $i<count($srcParams); $i++){
                         $goodsParam = $srcParams[$i][0];
                         $newGoosOne->addParam($goodsParam->parameter->id,$goodsParam->value);
                    }
                    return 1;
                }                
            }
            return 0;         
        }
    }
#класс описывает единицу товара из таблицы em_goods
    
    class Goods{
        public $id;                            			//ид товара в таблице em_goods
        public $categoryid;                           		//категория к которой относится товар
        public $imagefile;                         			 //изображение товара
        public $name;                       		//наименование товара
        public $desc;                                   //описание товара
        public $ordinal;                           //позиция в списке
        public $lastUpdate;                           //дата последнего редактирования
        public $metadescription;
        public $metakeywords;
        public $isArchivate;
        var $goodsParameter;                        //параметрвы описывающие товар
        
        function Goods($id){
            $this->id = $id;    
            $this->Load();              
        }
        
        public function Load(){
            $query = "SELECT id,categoryid, name,description,imagefile,ordinal,updatedate,metadescription,metakeywords,isarchivate FROM em_goods WHERE id = {$this->id}";
            //echo "<br>$query<br>";
            $res = mQuery($query);
            if ($res == null){                 echo "RES IS NULL<br/>";            }
            $row = mysql_fetch_row($res);
            $this->categoryid   = $row[1];
            $this->name         = $row[2];
            $this->desc         = $row[3];
            $this->imagefile    = $row[4];
            $this->ordinal      = $row[5];
            $this->metadescription      = $row[7];
            $this->metakeywords      = $row[8];
            $this->isArchivate  = $row[9];
            #определю параметры товара
            //$this->LoadGoodsParams();
        }
       
       public function save(){
           $name            = addslashes($this->name);
           $descr           = addslashes($this->desc); 
           $metaDescription = addslashes($this->metadescription);
           $metakeywords    = addslashes($this->metakeywords);
           
           $query = 
           "UPDATE em_goods SET
                categoryid      = {$this->categoryid},
                name            = \"{$name}\",
                description     = \"{$descr}\",
                imagefile       = \"{$this->imagefile}\",
                metadescription = \"{$this->metadescription}\",
                metakeywords    = \"{$this->metakeywords}\"
           WHERE id = {$this->id}";
           $res = mQuery($query);
        
       }
        
        public function getAllGoodsParam(){                                                                                                                                       
            $this->goodsParameter = null;
            $this->goodsParameter = Array();
            $query = "SELECT gp.id, gp.pvid , gp.value 
                        FROM em_goods_params gp, em_parameters p, em_param_value pv 
                        WHERE gid = {$this->id}
                        AND gp.pvid = pv.id
                        AND pv.pid = p.id
                        ORDER BY p.id, pv.id
                        ";
            
            $res = mQuery($query);
            while ($row = mysql_fetch_row($res)){
                $param  = new GoodsParameter($row[0]);
                $this->goodsParameter[count($this->goodsParameter)] = Array($param, $row[2]);
            }                       
            return $this->goodsParameter; 
        }
        
        public function getGoodsParam($pid){                                                                                                                                       
            $this->goodsParameter = Array();
            $query = "SELECT gp.id, gp.pvid , gp.value 
                        FROM em_goods_params gp, em_parameters p, em_param_value pv 
                        WHERE gid = {$this->id}
                        AND gp.pvid = pv.id
                        AND pv.pid = p.id
                        AND p.id = $pid
                        ORDER BY gp.value,p.id, pv.id
                        ";
                        //echo $query;
            $res = mQuery($query);
            while ($row = mysql_fetch_row($res)){
                $param  = new GoodsParameter($row[0]);
                $this->goodsParameter[count($this->goodsParameter)] = Array($param, $row[2]);
            }                       
            return $this->goodsParameter; 
        }        
        
        function addParam($pvid, $value){
            $insValue = stripslashes($value);
            $query = "INSERT INTO em_goods_params(gid,pvid,value) 
                      VALUES({$this->id},$pvid,'$insValue')";
            $res = mQuery($query);                       
            return mysql_insert_id();
        }      
        public function archivate(){
            $query = 
            "UPDATE em_goods
             SET isarchivate = 1
             WHERE id = {$this->id}";
             $res = mQuery($query);
             return 1;
        }      
        public function unArchivate(){
            $query = 
            "UPDATE em_goods
             SET isarchivate = 0
             WHERE id = {$this->id}";
             $res = mQuery($query);
             return 1;
        }
        function DeleteParam($id){           
            for($i=0; $i<count($this->goodsParameter); $i++){
                $param = $this->goodsParameter[$i][0];
                if ($param->id == $id){
                     $param->DeleteGoodsParam();
                     unset($this->goodsParameter[i]);
                     return 1;  
                }
            }
            return 0;
        }
    }
    
    #класс описывает параметр товара
    class GoodsParameter{
        public $id;                                                                            //id in table em_goods_param
        public $parentId;
        public $parameter;                                                                     //goods parameter  object of ParameterValue
        public $goodId;
        public $value;                                                                         //value of param? if need
        public $paramName;                                                                         //value of param? if need
        
        function  GoodsParameter($id){
            $this->id = $id;
            if (!$this->Load()){
            
            }
        }
        function NewGoodsParameter($pvid){
            $this->value = $value;             
            $query = "INSERT VALUES INTO em_goods_params(gid,pvid) 
                      VALUES({$this->id},$pvid)";
            $res = mQuery($query);
            $this->id = mysql_insert_id();
            Load();                    
        }
        
        public function Load(){
            $query = "SELECT pvid, value, gid, parentid FROM em_goods_params WHERE id = {$this->id}";       
            //echo $query ."<br>";
            $res = mQuery($query);
            if($row = mysql_fetch_row($res)){
                $this->parameter = new ParameterValue($row[0]);
                $this->value = $row[1];
                $this->goodId = $row[2];
                $this->parentId = $row[3];
                $query = "SELECT p.name FROM em_parameters p, em_param_value pv WHERE pv.pid=p.id AND pv.id={$row[0]}";
                $result = mQuery($query);
                if ($r = mysql_fetch_row($result)){
                    $this->paramName = $r[0];    
                }
                return true;
            }
            else
                return false;
        }                          
        
        public function Update($pvid){
            $newValue = stripcslashes($value);
            $query = "UPDATE em_goods_params SET pvid=$pvid WHERE id = {$this->id}";
            $res = mQuery($query);
            $this->value = $value;            
        }
        public function UpdateValue($value){
            $newValue = stripcslashes($value);
            $query = "UPDATE em_goods_params SET value = '$newValue' WHERE id = {$this->id}";
            $res = mQuery($query);
            $this->value = $value;            
        }
        
        public function DeleteGoodsParam(){
            $query = "DELETE FROM em_goods_params WHERE id = {$this->id}";
            $res = mQuery($query);
        }
        
        public function addChild($pvId){
            $query = "INSERT INTO em_goods_params(parentId,gid,pvid)
                        VALUES({$this->id},{$this->goodId},$pvId)";
            $res = mQuery($query);
        
        }          
    }
?>