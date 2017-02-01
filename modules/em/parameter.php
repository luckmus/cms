<?php
#класс описывает таблицу em_parameters
    class Parameters{
        public static $priceParam = 3;
        public $parameters;                                                                 //array of value table em_parameters
       
       
       function Parameters(){
            $res = mQuery("SELECT id FROM em_parameters WHERE relationFrom is NULL  ORDER BY ordinal");
            $this->parameters = Array();
            while($row = mysql_fetch_row($res)){
                 $this->parameters[count($this->parameters)] = new ParameterValues($row[0]);
            }        
       }
       //возвращает объект описывающий параметр по его id
       function getParameter($id){
            foreach($this->parameters as $p){
                if ($p->id==$id){
                    return $p;
                }            
            }
            return -1;
       } 
    }
    
#класс описывает запись в таблице em_parameters
    class ParameterValues{
        public $id;                                                                     //id in em_parameters
        public $name;                                                                   //name of param
        public $ordinal;                                                                //ordinal value
        public $values;                                                                 //array of ParameterValue
        public $relation = null;                                                               //зависимый параметр
       
       //по ид парараметра создает список его значений
       function ParameterValues($id){
            $this->id = $id;
            $this->Load();       
       }
       public function getElements(){
            return $this->values;
       }
       
       public function Load(){
           $query = "SELECT name, ordinal, relationfrom FROM em_parameters WHERE id = {$this->id}";
           $res = mQuery($query);
           $row = mysql_fetch_row($res);
           $this->name      = $row[0];
           $this->ordinal   = $row[1];
            $res = mQuery("SELECT id FROM em_param_value WHERE pid = {$this->id} ORDER BY ordinal");
            $this->values = Array();
            while($row = mysql_fetch_row($res)){
                 $this->values[count($this->values)] = new ParameterValue($row[0]); 
            }              
           //найду зависимые параметры
           $query = "SELECT id FROM em_parameters WHERE relationfrom = {$this->id}";
           $res = mQuery($query);
           if ($row = mysql_fetch_row($res)){
               $this->relation   = new ParameterValues($row[0]);
           }
       }
                
       public function haveRelation(){
            return  ($this->relation!=null);
       }       
       
       public function Add($value,$descr){
           //$value = stripslashes($value);
           $nextOrdinal =  $this->getNextOrdinal();
           $query = "INSERT INTO em_param_value(pid,value,description,ordinal) VALUES({$this->id}, '$value','$descr', $nextOrdinal)";
           $newId = mysql_insert_id();
           $this->values[] = new ParameterValue($newId);
            $res = mQuery($query);
       }
       
       public function getNextOrdinal(){
           $query = "SELECT MAX(ordinal)+1 FROM em_param_value WHERE pid = {$this->id}";
           $res = mQuery($query);
           $row = mysql_fetch_row($res);
           $res = $row[0];
           if(empty($res)){
               $res = 0;
           }
           return $res;
       }
    }
    #класс описывает запись в таблице em_param_value
    class ParameterValue{
        public $id;                                                                     //id in em_param_value
        public $pid;                                                                    //id in 
        public $value;                                                                  //value of param
        public $descr;                                                                  //description of param
        public $ordinal;                                                                //ordinal value
        
        function ParameterValue($id){
            $this->id = $id;
            $res = mQuery("SELECT id, ordinal, value, pid, description FROM em_param_value WHERE id = {$this->id}");
            $row = mysql_fetch_row($res);
            $this->ordinal = $row[1];
            $this->value = $row[2];                                              
            $this->pid = $row[3];                                              
            $this->descr = $row[4];                                              
        }     
        
        #изменяет значение параметра
        public function Edit($newValue,$newDescr){
            //$newValue = stripslashes($newValue);
            //$newDescr = stripslashes($newDescr);
            $res = mQuery("UPDATE em_param_value SET value = '$newValue', description = '$newDescr' WHERE id = {$this->id}");
        }
        
        public function Delete(){
            $res = mQuery("DELETE FROM em_param_value WHERE  id = {$this->id}");
        }
    }
?>