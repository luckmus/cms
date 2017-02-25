<?php
    $host = GetHost();
  if ($_SESSION[_LOGIN_ID]!=null){
    $lbl = '<a href="#" onclick="logOut();">Выход</a>|<a href="'.$host.'cabinet.php" >Личный кабинет</a>';
  }
  else{
      $s=rand(10000,99999); 
      $msgId = Message::processMsgId($s); 
      $lbl = '<a href="#"  onclick="showAuthorisationFromLogin(\'$msgId\',modalAuthPlace);">Регистрация</a> | <a href="#" onclick="showLogin(modalLoginPlace);">Авторизация</a>';
  }
  print $lbl; 
  
?>