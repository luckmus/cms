<?php
#класс описывает категирии, и их параметры
    class Categoryes{
        public $catArray;
        
        function Categoryes(){
             $this->Load();
        }
        
        public function LoadAll(){
            $query = "SELECT id FROM em_category WHERE order by ordinal";
            return $this->getList($query);
        }
        public function Load(){
            $query = "SELECT id FROM em_category WHERE isarchivate =0 order by ordinal";
            return $this->getList($query);
        } 
        public function LoadArchive(){
            $query = "SELECT id FROM em_category WHERE isarchivate = 1 order by ordinal";
            return $this->getList($query);
        }
        
                
        private function getList($query){
            $this->catArray = Array();
            $res = mQuery($query);
            while ($row = mysql_fetch_row($res)){
                $cat = new Category($row[0]);    
                $this->catArray[count($this->catArray)] = $cat;
            }
            return $this->catArray;            
        }
        
        public function getCategoryes(){
            return $this->catArray;   
        }
        
        private function getNextOrdinal(){
           $query = "SELECT MAX(ordinal)+1 FROM em_category";
           $res = mQuery($query);
           $row = mysql_fetch_row($res);
           $res = $row[0];
           if(empty($res)){
               $res = 0;
           }
           return $res;                
        }
        
        public function add($name, $descr, $img){
            $name = stripslashes($name);
            $descr = stripslashes($descr);
            $nextOrd =  $this->getNextOrdinal();
            $query = "INSERT INTO em_category(name, description,imagefile,ordinal) VALUES('$name', '$descr', '$img',$nextOrd)";           
            $res = mQuery($query);            
            $id = mysql_insert_id();
            $this->Load();
            return $id;
        }
        
        public function delete($id){
            $query = "SELECT count(*) FROM em_goods WHERE categoryid= $id";
            $res = mQuery($query);
            $row = mysql_fetch_row($res);
            if ($row[0]>0){
                return "Нельзя удалить категорию. За ней закреплены товары.";
            }
           $query = "DELETE FROM em_category_parameters WHERE categoryid = $id";
           $res = mQuery($query); 
           $query = "DELETE FROM em_category WHERE id = $id";
           $res = mQuery($query);        
           $this->Load();
           return 1;
        }
    }


    class Category{
      public $id;
      public $name;
      public $description;
      public $imagefile;
      public $ordinal;
      public $parameters;
      private $isArchivate;
      
      function Category($id){
        $this->id = $id;      
      }
      
      public function Load(){

        $this->loadProperties();
        $this->LoadParameters();
      } 
      public function loadProperties(){
        $query = "SELECT id, name, description,imagefile,ordinal,isarchivate FROM em_category WHERE id = {$this->id}";
        $res = mQuery($query);
        while ($row = mysql_fetch_row($res)){
            $this->name         = $row[1];
            $this->description  = $row[2];
            $this->imagefile    = $row[3];
            $this->ordinal      = $row[4];
            $this->isArchivate  = $row[5];
        }          
      }
      #грузитьсписок параметров этой категории
      private function LoadParameters(){
        $query = "SELECT id,categoryid, parameterid FROM em_category_parameters WHERE categoryid = {$this->id} order by ordinal";
        $res = mQuery($query);
        $this->parameters = Array();
        while ($row = mysql_fetch_row($res)){
            $param = new ParameterValues($row[2]);
            $this->parameters[count($this->parameters)] = $param;
        }
      }
      #список всех параметров, за исключением зависимых
      public function getAviableParameters(){
        $res = Array();
        $query = "SELECT parameterid FROM em_category_parameters cp, em_parameters p  
                  WHERE cp.parameterid = p.id
                  AND p.relationfrom  IS NULL
                  AND categoryid = {$this->id}
                  ORDER by cp.ordinal";
        $result = mQuery($query);
        while ($row = mysql_fetch_row($result)){
            $res[count($res)] = new ParameterValues($row[0]);   
        }
        return $res;        
      }        
        public function updCategory($name, $descr, $img){
            $this->name         = $name;
            $this->description  = $descr;
            $this->imagefile    = $img;            
            $name = stripslashes($name);
            $descr = stripslashes($descr);
            $img = stripslashes($img);
            $query = "UPDATE em_category SET name = '$name', description = '$descr', imagefile = '$img' WHERE id = {$this->id}";
            $res = mQuery($query);
            
        }
        
        public function addParam($paramId){
            $ordinal = $this->getNextOrdinal();
            $query = "INSERT INTO em_category_parameters(categoryid, parameterid, ordinal) VALUES({$this->id}, $paramId,$ordinal)";
            $res = mQuery($query);
            $this->LoadParameters();         
        }
        private function getParamOrdinal($pid){
            $query = "SELECT cp1.ordinal FROM em_category_parameters cp1 WHERE cp1.categoryid = {$this->id} AND cp1.parameterid=$pid";
            $res = mQuery($query);
            $row = mysql_fetch_row($res);
            $moveParamOrd = $row[0];
            return $moveParamOrd;             
        }
        public function downParam($pid){
            $msg = "Нельзя сдвинуть параметр ниже";
            $moveParamOrd = $this->getParamOrdinal($pid);
            if($moveParamOrd==$this->getNextOrdinal()-1){
                return $msg;
            }
            //полу id параметра скоторым буду менять местами
            $query = "SELECT id,min(ordinal)from em_category_parameters WHERE categoryid = {$this->id} 
                  AND ordinal>$moveParamOrd";
                  
            $query = "SELECT ec.id,ec.ordinal from em_category_parameters ec WHERE ec.categoryid = {$this->id} 
                      AND ec.ordinal=(SELECT MIN(ecp.ordinal) from em_category_parameters ecp WHERE ecp.categoryid = ecp.categoryid 
                      AND ecp.ordinal>$moveParamOrd)";
            $res = mQuery($query);
            if (!$row = mysql_fetch_row($res)){
                return $msg."error";
            }
            $newOrd = $row[1];
            $neighbourId = $row[0];
            $query = "UPDATE em_category_parameters 
                      SET ordinal = $newOrd
                      WHERE categoryid = {$this->id} AND parameterid=$pid";
            $res = mQuery($query);
            $query = "UPDATE em_category_parameters 
                      SET ordinal = $moveParamOrd
                      WHERE id= $neighbourId";
            $res = mQuery($query);
            return 1;
        }
        public function upParam($pid){
            $msg = "Нельзя сдвинуть параметр выше";
            $query = "SELECT min(ordinal) from em_category_parameters WHERE categoryid = {$this->id}";
            $res = mQuery($query);
            $row = mysql_fetch_row($res);
            $moveParamOrd = $this->getParamOrdinal($pid);
            if($moveParamOrd==$row[0]){
                return $msg;
            }
            //полу id параметра скоторым буду менять местами
            $query = "SELECT id,max(ordinal)from em_category_parameters WHERE categoryid = {$this->id} 
                  AND ordinal<$moveParamOrd";
                  
            $query = "SELECT ec.id,ec.ordinal from em_category_parameters ec WHERE ec.categoryid = {$this->id} 
                      AND ec.ordinal=(SELECT MAX(ecp.ordinal) from em_category_parameters ecp WHERE ecp.categoryid = ecp.categoryid 
                      AND ecp.ordinal<$moveParamOrd)";
            $res = mQuery($query);
            if (!$row = mysql_fetch_row($res)){
                return $msg."error";
            }
            $newOrd = $row[1];
            $neighbourId = $row[0];
            $query = "UPDATE em_category_parameters 
                      SET ordinal = $newOrd
                      WHERE categoryid = {$this->id} AND parameterid=$pid";
            $res = mQuery($query);
            $query = "UPDATE em_category_parameters 
                      SET ordinal = $moveParamOrd
                      WHERE id= $neighbourId";
            $res = mQuery($query);
            return 1;
        }        
        public function delParam($pid){                            
            $query = "DELETE FROM em_category_parameters WHERE categoryid = {$this->id} AND parameterid=$pid";
            $res = mQuery($query);
            $this->LoadParameters();
        }
        private function getNextOrdinal(){
            $query = "SELECT max(ordinal)+1 from em_category_parameters WHERE categoryid = {$this->id}";
            $res = mQuery($query);
            $row = mysql_fetch_row($res);
            if ($row[0]==null){
                $row[0] = 1;
            }
            return $row[0];
        }      
        public function getFreeParams(){
            $query = "SELECT p.id FROM em_parameters p WHERE p.id NOT IN (SELECT c.parameterid FROM em_category_parameters c WHERE categoryid = {$this->id})";
            $res = mQuery($query);
            $fRes = Array();
            while ($row = mysql_fetch_row($res)){
                $fRes[count($fRes)] = new ParameterValues($row[0]);
            }
            return $fRes;
        }    
        
        
    }

?>