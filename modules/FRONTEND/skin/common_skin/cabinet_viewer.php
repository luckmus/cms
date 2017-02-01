<?php
    #класс описывает внешний вид кабинета
    class CabinetViewer{
        public $account;
        function CabinetViewer($id){
            $this->account = new Account($id);
            $this->account->load();
        }
        public static function getView($id){
            $view = new CabinetViewer($id);
            $res = $view->getAccountDataView();
            return $res;
        }    
       public function getAccountAbout(){

                $msgText = "<table class=\"cabinet-account-data\">";
    $msgText .= "<tr>";
    
    $msgText .= "<td>";
    $msgText .= "Логин:";
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    $msgText .= $this->account->login;
    $msgText .= "</td>";
    
    $msgText .= "</tr>";
    
     $msgText .= "<tr>";
    
    $msgText .= "<td>";
    $msgText .= "Имя:";
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    $msgText .= $this->account->lastname;
    $msgText .= "</td>";
    
    $msgText .= "</tr>";
    
    $msgText .= "<tr>";
    
    $msgText .= "<td>";
    $msgText .= "Фамилия:";
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    $msgText .= $this->account->firstName;
    $msgText .= "</td>";
    
    $msgText .= "</tr>";
    
    $msgText .= "<tr>";
    
    $msgText .= "<td>";
    $msgText .= "Телефон:";
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    $msgText .= $this->account->tel;
    $msgText .= "</td>";
    
    $msgText .= "</tr>";
    
    $msgText .= "<tr>";
    
    $msgText .= "<td>";
    $msgText .= "e-mail:";
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    $msgText .= $this->account->email;
    $msgText .= "</td>";
    
    $msgText .= "</tr>";
    
    $msgText .= "<tr>";
    
    $msgText .= "<td>";
    $msgText .= "Адрес:";
    $msgText .= "</td>";
    
    $msgText .= "<td>";
    $msgText .= $this->account->adres;
    $msgText .= "</td>";
    
    $msgText .= "</tr>";

    
    $msgText .= "</table>";
        RETURN $msgText;            
       }
       public function getAccountDataView(){
           $msgText = $this->getAccountAbout();
            $msgText .= "<div><a href=\"javascript:void(0);\" onClick=\"showAuthorisationFE(modalAuthPlace,{$this->account->id});\">Править</a></div>";
            return $msgText;
       }        
    }
?>