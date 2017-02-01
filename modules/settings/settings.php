<?php
    
    class Setting{
        private $id;
        private $description;
        private $value;
        private $ordinal;
        private $name;
        private $type;
        
        public static $TYPE_STRING     = 0; 
        public static $TYPE_TEXT       = 1; 
        public static $TYPE_NUMBER     = 2; 
        public static $TYPE_BOOLEAN    = 3; 
        
        function Setting($id){
            $this->id =$id; 
        }
        
        function init(){
            $query = "select  description, value, ordinal, name, type FROM settings WHERE id='{$this->id}'";
            $res = mQuery($query);
            $row = mysql_fetch_row($res);
            $this->description = $row[0];
            $this->value = $row[1];
            $this->ordinal = $row[2];
            $this->name = $row[3];
            $this->type = $row[4];
        }
        public static function initSetting(){
            $res = mQuery("SELECT name,value FROM settings");
            while($row = mysql_fetch_row($res)){
                $$row[0] = $row[1];
                $GLOBALS[$row[0]] =  $row[1]; 
                //echo "$row[0] = ".$$row[0]."<br>";
            }        
        }
        public static function getSettings(){
            $result = Array();
            $res = mQuery("SELECT id FROM settings");
            while($row = mysql_fetch_row($res)){
                $setting = new Setting($row[0]);
                $setting->init();
                $result[count($result)] = $setting;
            }             
            return $result;
        }        
        public function save(){
            $value = addslashes($this->value);
            $query = 
            "UPDATE settings
             SET value = '$value'
             WHERE id = {$this->id}";
             $res = mQuery($query);
             return 1;
        }
            
    }
    
  class SettingsCtrl{
    private $setting;                   //объект Setting
    private $templId = "";              //временный идентефикатор, бужет прибавляться к именам GET
     
    function SettingsCtrl($setting){
        $this->setting = $setting;    
    }
    
    public function getFormName(){
        return "{$this->setting->name}_{$this->templId}";
    }
    
    public function getFormElem(){
        $res = '';
        switch ($this->setting->type){
            case Setting::$TYPE_NUMBER:
            case Setting::$TYPE_STRING:
                $res = "<input type=\"TEXT\" name=\"{$this->getFormName()}\" value=\"{$this->setting->value}\" size=\"25\" />";
            break;
            
            case Setting::$TYPE_BOOLEAN:
                if ($this->setting->value=="1"){
                    $value="checked";
                }                    
                $res = "<input type=\"CHECKBOX\" name=\"{$this->getFormName()}\" $value  />";
            break;
            
        }
        return $res;
    }
   public static function getCtrlTable(){
       $res = "<table border=\"1\">";
       $settings = Setting::getSettings();       
       for ($i=0; $i<count($settings); $i++){
           $setting = $settings[$i];
           $settingCtrl = new SettingsCtrl($setting);
        $res .= 
            "<tr>
                <td>
                    {$setting->name}
                </td>
                <td>
                {$settingCtrl->getFormElem()}
                </td>
              </tr>
                ";
       }
       $res .= "</table>";
   } 
  }  
?> 