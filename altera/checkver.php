<?php
  include "../config.php";
  include "../libs/db.php";
  $dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
  $userver = htmlspecialchars($_GET['rver']);
  $q = 'SELECT versionui,relieasedate FROM alteraversion';
  $res = mQuery($q);
  $row = mysql_fetch_array($res);
  $userver = str_replace('.','',$userver);
  $actualveri = str_replace('.','',$row[0]);
  $actualver = $row[0];
  if ($actualveri>$userver)
  {
    #��������� ����������, ������� ����� ��������� ������
    echo $actualver;
    return;
  }
  else
  {
      #���������� �� ���������
      echo '0';
  }   
  

?>