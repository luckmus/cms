<?php
    class Account extends UserCommunication{
       public $id;
       public $login; 
       public $pwd; 
       public $firstName; 
       public $lastname;
       public $date;
       public $tel;
       public $email;
       public $adres;    
       
       function  Account($id){
            $this->id = $id;
       }
       public function load(){
           if ($this->id==null){
            return false;
           }
            $query = "SELECT LOGIN, firstname, lastname, tel, email, adres, regdate, pwd FROM em_account WHERE id = {$this->id}";
            $res = mQuery($query);
            if ($row = mysql_fetch_row($res)){
                $this->login        = $row[0];
                $this->firstName    = $row[1];
                $this->lastname     = $row[2];
                $this->tel          = $row[3];
                $this->email        = $row[4];
                $this->adres        = $row[5];
                $this->date         = $row[6];
                $this->pwd          = $row[7];
            }
            else{
                return false;
            }
       }
       public function save(){
            if (!$this->checkLogin()){
                return "����� {$this->login} �����.";
            }           
            if($this->id==null){
                $this->insert();
            }
            else{
                $this->update();
            }
            return 1;
       }
       
       private function insert(){
           $query = "
            INSERT INTO em_account(firstname,
                lastname,
                tel,
                email,
                adres,
                login,
                pwd)
            VALUES(\"{$this->firstName}\",
                \"{$this->lastname}\",
                \"{$this->tel}\",
                \"{$this->email}\",
                \"{$this->adres}\",
                \"{$this->login}\",
                \"{$this->getPWD()}\")";
            $res = mQuery($query);
            $this->id = mysql_insert_id();
       }
       private function update(){
           $query = 
            "UPDATE em_account
             SET firstname = \"{$this->firstName}\",
                login =   \"{$this->login}\",
                pwd =   \"{$this->getPWD()}\",
                lastname = \"{$this->lastname}\",
                tel = \"{$this->tel}\",
                email = \"{$this->email}\",
                adres = \"{$this->adres}\",
                regdate = CURRENT_TIMESTAMP()
             WHERE id = {$this->id}";
             $res = mQuery($query);     
       }
       function getPWD(){
            return md5($this->pwd);
       }

       private function baseCheck($rcontrdig,$repwd){

            $ErrMes = '';
            if ($this->lastname=='')
                $ErrMes .= '��� �� �������. ';            
            
            if ($this->login=='')
                $ErrMes .= '����� �� ������. ';

            if ($this->pwd=='')
                $ErrMes .= '������ �� ������. ';

            if ($repwd=='')
                $ErrMes .= '��������� ������ �� ������. ';                

            if ($this->tel=='')
                $ErrMes .= '������� �� ������. ';
                
            if ($this->email=='')
                $ErrMes .= 'email �� ������. ';
                
                                
            if ($this->email!=''){
                if (!preg_match("|^([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|is", strtolower($this->email)))
                {
                    $ErrMes .= '������ ������������ email. ';
                }
            }

            if ($ErrMes=='')   
            {
                if ($_SESSION['contrdig']=='')
                    $ErrMes = '����������� ����� �� �������';
                else        
                if ($_SESSION['contrdig']!=$rcontrdig)
                    $ErrMes = '�������� ����������� �����';
            }
            return $ErrMes;             
       
       }
       public function checkForm($rcontrdig,$repwd)
        {      
            $ErrMes = "";
            $ErrMes .= $this->baseCheck($rcontrdig,$repwd);    
            if (($this->pwd!='')&& ($repwd!='') && ($repwd!=$this->pwd))            
                $ErrMes .= "������ � ������ ������ �� ��������� .($repwd!={$this->pwd})";                                                                                                                    
            return $ErrMes;                      
        }       
       public function checkFormWithOld($rcontrdig,$newPwd,$repwd,$oldpwd){
                $ErrMes .= $this->baseCheck($rcontrdig,$repwd);
                if ($newPwd!=$repwd){
                   $ErrMes .= "����� � ��������� ������ �� ���������. ";
                }
                if ($this->pwd!=md5($oldpwd)){
                    $ErrMes .= "�������� ������ ������. ";
                }
         return $ErrMes;
       }        

        public function checkLogin(){
            $query = "SELECT count(*) from em_account WHERE upper(login)=upper(\"{$this->login}\") ";
            if ($this->id != null){
                $query .= " AND id != {$this->id}";
            }
            $res = mQuery($query);
            $row = mysql_fetch_row($res);
            return ($row[0]==0);
                
        }        
        
        static public function checkRegistration($login, $pwd){
            $pwd = md5($pwd);
            $query = "SELECT id FROM em_account WHERE upper(login)=upper(\"$login\") AND pwd = \"$pwd\"";
            $res = mQuery($query);
            if($row = mysql_fetch_row($res)){                
                return ($row[0]);
            }
            else{
                return null;
            }
            
        }
       static public function getListOfAccount(){
           $result = Array();
           $query = "SELECT id FROM em_account order by regdate"; 
           $res = mQuery($query);
           while ($row = mysql_fetch_row($res)){
            $result[count($result)] = new Account($row[0]);
           }
           return $result;
       }
    }
?>