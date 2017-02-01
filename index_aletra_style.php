<?php

session_start();
include "libs/helpers.php";
include "libs/db.php";
include "config.php";
include "libs/vars.php";
$dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
include "libs/initvars.php";
include "libs/init_settings_var.php"; 
mQuery("SET NAMES 'cp1251'", $dbh);
//getLastModified($show,$id);
if (($show == 'goods') && ($issave==1))
{
    include "scripts/order.php";
}    
?>
<html>
<head>
<link rel="shortcut icon" href="img/favicon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />

<?php
echo '<title>'._title.' - '.getTitle($show,$id).'</title>';
?>
<?php
    if ($show == '') 
        $show = 'info';
    $meta = getMetaTags($show,$id);
    //echo htmlspecialchars($meta);
    echo"$meta";
?>

<link href="css/style.css" rel="stylesheet" type="text/css">
<?php
    print "   <link rel=\"StyleSheet\" href=\"main.css\" type=\"text/css\">";
    print "   <script language=\"JavaScript\" type=\"text/javascript\" src=\"jsa/ajax.js\"></script>";
    print "   <script language=\"JavaScript\" type=\"text/javascript\" src=\"jsa/init.js\"></script>";
?>
</head>

<body>
<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="company_name"><span class="blue">Altera</span> project</td>
        <td><img src="images/ts.gif" alt="" width="3" height="45"></td>
        <td class="slogan1">
        <?php
            if  ($show!="search")
            {
                print "<div id='progressbox'>";
                searchForm(40,$DefaultSearch,$FastSearchButton);
                print"</div>";        
            }
        ?>
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td background="images/mbg.gif" bgcolor="#2b82ca"><table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="menu"><a href="?">Главная</a></td>
        <td><img src="images/ms.gif" alt="" width="11" height="31"></td>
        <td class="menu"><a href="?show=info&id=22">Проекты</a></td>
        <td><img src="images/ms.gif" alt="" width="11" height="31"></td>
        <td class="menu"><a href="?show=info&id=23">Клиенты</a></td>
        <td><img src="images/ms.gif" alt="" width="11" height="31"></td>
        <td class="menu"><a href="?show=allnews">Новости</a></td>
        <td><img src="images/ms.gif" alt="" width="11" height="31"></td>
        <td class="menu"><a href="?show=allask">Вопросы</a></td>
        <td><img src="images/ms.gif" alt="" width="11" height="31"></td>
        <td class="menu"><a href="?show=info&id=3">Контакты</a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><div style="position:absolute; margin-left:740px; margin-top:107px; z-index:2">
    <img src="images/p2small-bg.gif" alt="">
    </div><div class="smenu">
    <div><img src="images/ms-top.gif" alt="" width="203" height="14"></div>
        <a href="?show=info&id=23">Клиенты</a>
        <a href="/?show=info&id=24">Скачать</a>
        <a href="http://alteraproject.ru/punbb">Форум</a>
    <div><img src="images/ms-bottom.gif" alt=""></div>
    <div><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="images/spacer.gif" alt="" width="1" height="4"></td>
  </tr>
  <tr>
    <td><img src="images/rtoppan.gif" alt="" width="203" height="3"></td>
  </tr>
  <tr>
    <td class="r-title">Последние новости</td>
  </tr>
  <tr>
    <td class="r-panel-cont"><p>
<?php
  showAllNews();
  #слой для вывода больших фотографий
  /*
  print "<div id='smallplace'  class=\"message\">";
  print "<table border = 1 width='99%'>";
  print "<tr>";
  print "<td>";
  print "<div align='RIGHT'><img src='img/close.png' onClick=\"HideDiv('smallplace');\"></div>";
  print "</td>";
  print "</tr>";
  print "<tr>";
  print "<td>";
  print "<div id='smallimg' vertical-align='middle' align = 'CENTER' ></div>";
  print "</td>";
  print "</tr>";
  print "</table>";
  print "</div>";
 */ 
?>    
</p>
      </td>
  </tr>
  <tr>
    <td><img src="images/r-botpanel.gif" alt="" width="203" height="5"></td>
  </tr>
  <tr>
    <td><img src="images/spacer.gif" alt="" width="1" height="1"></td>
  </tr>
</table>
</div>
    </div><div class="slogan">Комплексное решение для<br> 
     
      <img src="images/spacer.gif" alt="" width="76" height="1">агентств недвижимости</div>
    <img src="images/p1.jpg" alt="" width="750" height="184"></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">
        
      <div class="body_txt">
<?php
//вывод основной информации
ShowData($show,$id);
?>      
  <!--    <div style="border:#0C287A solid 1px;padding:4px 6px 2px 6px">Второй человек, получивший контракт, Билл, на некоторое время исчез из деревни. Он не появлялся несколько месяцев. Это радовало Эда, ведь у него не было соперника. Эду одному доставались все деньги за снабжение водой.</div>--!>
      <p>&nbsp;</p>
      </div></td>
  </tr>
  <tr>
    <td bgcolor="#94cbf7"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="bottom_menu"><a href="?">Главная</a>  |  <a href="?show=info&id=22">Проекты</a>  |  <a href="?show=info&id=23">Клиенты</a>  |  <a href="?show=allnews">Новости</a>  |  <a href="?show=allask">Задать вопрос</a>  |  <a href="?show=info&id=3">Контакты</a></td>
      </tr>
      <tr>
        <td class="bottom_addr">&copy; 2011 <a href='http://www.alteraproject.ru'>AlteraProject</a></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
