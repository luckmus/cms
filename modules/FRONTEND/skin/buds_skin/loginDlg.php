<?php
    $host = GetHost();
  if ($_SESSION[_LOGIN_ID]!=null){
    $lbl = '<a href="#" onclick="logOut();">�����</a>|<a href="'.$host.'cabinet.php" >������ �������</a>';
  }
  else{
      $s=rand(10000,99999); 
      $msgId = Message::processMsgId($s); 
      $lbl = '<a href="#"  onclick="showAuthorisationFromLogin(\'$msgId\',modalAuthPlace);">�����������</a> | <a href="#" onclick="showLogin(modalLoginPlace);">�����������</a>';
  }
  print $lbl; 
  
?>