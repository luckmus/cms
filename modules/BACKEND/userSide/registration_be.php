<?php
    header("Content-type: text/html; charset=windows-1251");
    session_start();
    include "../../../config.php"; 
    include "../../../libs/db.php";    
    include "../../../libs/vars.php";    
    include "../../em/usercommunication.php";
    include "../../em/em_accounts.php";
    include "../../../libs/commonfunctions.php"; 
    include "../../../libs/helpers.php"; 
    
    $dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
    mQuery("SET NAMES 'cp1251'", $dbh); 
    
    
    $mode = $_POST['mode'];
    switch($mode){
        case "0":
        case "3":
            $userId = $_POST['userId'];
            if ($userId==''){
                $userId = null;
            }
            $account = new Account($userId);            
            $account->load();
            $pwd =  strtolower(convertToWIN1251(addslashes($_POST['pwd'])));
            $oldpwd =  strtolower(convertToWIN1251(addslashes($_POST['oldpwd'])));
            $repwd =  strtolower(convertToWIN1251(addslashes($_POST['repwd'])));
            $account->firstName =  convertToWIN1251(addslashes($_POST['name']));
            $account->lastname = convertToWIN1251(addslashes($_POST['lastname']));
            $account->tel = convertToWIN1251(addslashes($_POST['tel']));
            $account->email = convertToWIN1251(addslashes($_POST['email']));
            $account->adres = convertToWIN1251(addslashes($_POST['adress']));
            $rcontrdig = addslashes($_POST['rcontrdig']);            
            switch ($mode){
                case "0":
                    $account->login =  convertToWIN1251(addslashes($_POST['login']));            
                    $account->pwd = $pwd;
                    $ErrMes = $account->checkForm($rcontrdig,$repwd);
                break;
                case "3":                    
                    $ErrMes = $account->checkFormWithOld($rcontrdig,$pwd, $repwd,$oldpwd);
                    $account->pwd = $pwd;
                break;
            }
            
            if ($ErrMes != '')         
            {
                echo $ErrMes;
                return;   
            }     
           echo $account->save();
        break;   
        case "1":
            $id = Account::checkRegistration(convertToWIN1251(addslashes($_POST['login'])), strtolower(convertToWIN1251(addslashes($_POST['pwd'])))); 
            if ($id!=null){
                $_SESSION[_LOGIN_ID] = $id;
                echo 1;
            }
            else{
                echo 0;
            }
        break;
        case "2":
            $_SESSION[_LOGIN_ID] = null;
            echo 1;                
        break;
    }//switch($mode)

?>