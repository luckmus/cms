<?php
$show=$_GET['show'];
if ($show=="") $show=$_POST['show'];

$id=$_GET['id'];
if ($id=="") $id=$_POST['id'];

$issave = $_POST['issave'];

if ($show=='')
{
  $show="info";
  $id=1;
}
/*
#установлю номер кнопки flash меню
if (($id!="")  && ($show!="news"))
{
  $result=mQuery("SELECT butNum FROM pages WHERE id=$id");
  $row=mysql_fetch_array($result);
  $FlMenuBut = $row[0];
}
*/
$mesid = $_GET['mesid'];
if ($show=="quetion")
{
 #инициализирую переменные формы "Вопроса"
 $qname=$_POST['qname'];
 $email=$_POST['email'];
 $qtext=$_POST['qtext'];
 $cd=$_POST['contrdig'];
 $issend=$_POST['issend'];
 $FlMenuBut=6;
}
if ($show=="addregard")
{
  #инициализирую переменные формы "отзыва"
  $rname=$_POST['rname'];
  $firm=$_POST['firm'];
  $position=$_POST['position'];
  $rcd=$_POST['rcontrdig'];
  $isrsend=$_POST['isrsend'];
  $rtext=$_POST['rtext'];
  $FlMenuBut=5;
}
if ($show=="allregards")
{
   $FlMenuBut=5;
}
if ($show=="allask")
{
   $FlMenuBut=6;
}

//if (($FlMenuBut=="") && ($show==""))
//{
//   $FlMenuBut=1;
//}
//else
//{
//  $FlMenuBut=0;
//}
if ($FlMenuBut!=0)
   $GifMenuBut=$FlMenuBut-1;
else
   $GifMenuBut=$FlMenuBut;
 #создам массив с имнами кнопок для gif версии
  $ArButtons = Array();

  $ArButtons[0][0]="main.png";
  $ArButtons[0][1]="mainsel.png";

  $ArButtons[1][0]="sevices.png";
  $ArButtons[1][1]="sevicessel.png";

  $ArButtons[2][0]="contact.png";
  $ArButtons[2][1]="contactsel.png";

  $ArButtons[3][0]="vacansy.png";
  $ArButtons[3][1]="vacansysel.png";

  $ArButtons[4][0]="regards.png";
  $ArButtons[4][1]="regardssel.png";

  $ArButtons[5][0]="ask.png";
  $ArButtons[5][1]="asksel.png";
  
  #выберу ту страницу gif, которая выбрана
 $ArButtons[$GifMenuBut][0] = $ArButtons[$GifMenuBut][1];

$FromNews=$_GET['fromnews'];
if ($FromNews=="") $FromNews=$_POST['fromnews'];
if ($show=='news') $FromNews=$id;
if ($FromNews=="") $FromNews=0;

$npage=$_GET['npage'];
if ($npage=="") $npage=$_POST['npage'];
if ($npage=="") $npage=1;

$rpage=$_GET['rpage'];
if ($rpage=="") $rpage=$_POST['rpage'];
if ($rpage=="") $rpage=1;

$apage=$_GET['apage'];
if ($apage=="") $apage=$_POST['apage'];
if ($apage=="") $apage=1;

$spage=$_GET['spage'];
if ($spage=="") $spage=$_POST['spage'];
if ($spage=="") $spage=1;

$stext=$_GET['stext'];
$smode=$_GET['smode'];
?>
