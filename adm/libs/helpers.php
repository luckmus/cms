<?php
//include("../modules/em/usercommunication.php");
//require_once("../modules/em/em_goods.php");
//
//require_once("../modules/em/em_Order.php");

function ShowAdmPart($show)
{
 global $action,$id,$SystemMessage,$order,$RegardLen,$AnswerLen,$QuetionLen;
  switch ($show)
  {
    #�������
    case "parts":
      switch ($action)
      {
         case "add":
              EditParts("");
         break;
         case "edit":
              EditParts($id);
         break;
         default:
           include "parts.php";
         break;
      }
    break;
    #�������
    case "news":
      switch($action)
      {
         case "add":
              EditNews("");
         break;
         case "edit":
              EditNews($id);
         break;
         default:
           include "news.php";
         break;
      }
    break;
    #��������
    case "info":
      switch($action)
      {
         case "add":
              EditPages("");
         break;
         case "edit":
              EditPages($id);
         break;
         default:
           include "info.php";
         break;
      }
    break;
    #������
    case "regards":
      switch($action)
      {
         case "view":
              ViewRegurds($id);
         break;
         default:
           include "regards.php";
         break;
      }
    break;

    #�������
    case "ask":
      switch($action)
      {
         case "add":
              EditAsk("");
         break;
         case "edit":
              EditAsk($id);
         break;
         default:
           include "ask.php";
         break;
      }
    break;  
    #��������
    case "upload":
      switch($action)
      {
         case "add":
              $r = EditFile("");
         break;       
         default:
           include "upload.php";
         break;
      }
    break;  
    #���������
    case "category":
    /*
      switch ($action)
      {
         case "add":
              Edit�ategory("");
         break;
         case "edit":
              Edit�ategory($id);
         break;
         default:
           include "category.php";
         break;
      }
      */
      echo "<div id='"._ALL_CATEG_CONT."'>";
      include "jCategory.php";
      echo "</div>";
    break;    
    #������
    case "goods":       
      $GLOBALS[_IS_ARCH]=0;
      echo "<div id='"._ALL_GOODS_CONT."'>";
      include "goods.php";
      echo "</div>";    
      break;    
    #������
    case "archgoods":       
      $GLOBALS[_IS_ARCH]=1;
      echo "<div id='"._ALL_GOODS_CONT."'>";
      include "goods.php";
      echo "</div>";    
      break;
    # ���������
    case "params":
        include "parametrs.php";
    break;
    #���������
    case "settings":
      switch($action)
      {
         case "edit":
              EditSettings();
         break;
         default:
           include "settings.php";
         break;
      }      
    break;  
    #������
    case "orders":
      switch($action)
      {
         case "edit":
                include "../modules/FRONTEND/skin/common_skin/cabinet_viewer.php";
                include "../modules/em/usercommunication.php";
                include "../modules/em/em_accounts.php";
                include "../modules/em/em_goods.php";
              EditOrders($id);
         break;
         default:
           include "orders.php";
         break;
      }
    break;  
    #���������
    case "promo":
        include "../modules/em/em_promo.php";
      switch($action)
      {
         case "edit":

         break;
         default:
     echo "<div id='"._ALL_PROMO_CONT."'>";
      include "promo.php";
      echo "</div>";          
           
         break;
      }
    break;     
  }
  
  
  
}

#������� ����������� ������� �� 1 ������ ����
function up($id,$dir)
{
  $result=mQuery("SELECT  ordinal  FROM $dir where id=$id");
  $row=mysql_fetch_array($result);
  $myOrd=$row[0];
  if ($dir=="pages")
  {
    global $pid;
    $where=" WHERE pid=$pid ";
  }
  $result=mQuery("SELECT min(ordinal) FROM $dir $where");
  $row=mysql_fetch_array($result);
  $minOrd=$row[0];
  #��������, ���� �� ���� ���������
  if (($myOrd==0) || ($myOrd==$minOrd))
  {
    return "������ �������� �����.";
  }
  #����� � �������� �������
  $result=mQuery("SELECT id,ordinal FROM $dir WHERE ordinal<$myOrd order by ordinal desc");
  $row=mysql_fetch_array($result);
  #���� ���� ordinal ������
  $result=mQuery("UPDATE $dir SET ordinal=$row[1] WHERE id=$id");
  #���� ������ ���� ordinal
  $result=mQuery("UPDATE $dir SET ordinal=$myOrd WHERE id=$row[0]");

}
#������� ���������� ������� �� 1 ������ ����
function down($id,$dir)
{
  $result=mQuery("SELECT  ordinal  FROM $dir where id=$id");
  $row=mysql_fetch_array($result);
  $myOrd=$row[0];
  if ($dir=="pages")
  {
    global $pid;
    $where=" WHERE pid=$pid ";
  }
  $result=mQuery("SELECT max(ordinal) FROM $dir $where");
  $row=mysql_fetch_array($result);
  $maxOrd=$row[0];
  $maxOrd=MaxOrd($dir,$pid);
  #��������, ���� �� ���� ���������
  if  ($myOrd==$maxOrd)
  {
    return "������ �������� ����. $maxOrd";
  }
  #����� � �������� �������
  $result=mQuery("SELECT id,ordinal FROM $dir WHERE ordinal>$myOrd order by ordinal");
  $row=mysql_fetch_array($result);
  #���� ���� ordinal ������
  $result=mQuery("UPDATE $dir SET ordinal=$row[1] WHERE id=$id");
  #���� ������ ���� ordinal
  $result=mQuery("UPDATE $dir SET ordinal=$myOrd WHERE id=$row[0]");
}
#������� ������������� ���������� parts
function EditParts($id)
{
  global $name,$issave;
  if($issave=="")
  {
  $pname="";
  if ($id!="")
  {
    $result=mQuery("SELECT name FROM parts WHERE id=$id");
    $row=mysql_fetch_array($result);
    $pname=$row[0];
  }
  print "<div class=\"answer\" align=\"CENTER\">�������������� �������.</div><br>";
  print "<form method=\"POST\" id='mainform' onsubmit=\"document.getElementById('idsave').value='���������';\">";
  print "</b>������������ �������</b><br>";
  print "<input type=\"TEXT\" name=\"name\" size=\"25\" maxlength=\"25\" value=\"$pname\"><br>";
  print "<input type=\"HIDDEN\" name=\"id\" value=\"$id\">";
  print "<input type=\"HIDDEN\" name=\"action\" value=\"addresult\">";
  print "<input type=\"HIDDEN\" name=\"show\" value=\"parts\">";
  print "<input type=\"HIDDEN\" id=\"idsave\" name=\"issave\" value=\"1\">";
  print "<input type=\"SUBMIT\"  name=\"save\" value=\"���������\">";
  print "</form>";
  }
  else
  {
    $pname=$name;
    if ($pname=="")
      $pname="�� �������";
    if ($id=="")
    {
      $ord=MaxOrd("parts","");
      $ord++;
      $result=mQuery("INSERT INTO parts(name,ordinal) VALUES('$pname',$ord)");
    }
    else
    {
       $result=mQuery("UPDATE parts SET name='$pname' WHERE id=$id");
    }
  }

}
#������� ������������� ���������� em_category
function Edit�ategory($id)
{
  global $name, $issave,$descr,$imagefile;
  if($issave=="")
  {
  $pname="";
  if ($id!="")
  {
    $result=mQuery("SELECT name, description, imagefile FROM em_category WHERE id=$id");
    $row=mysql_fetch_array($result);
    $name=stripslashes($row[0]);
    $descr =  stripslashes($row[1]);
    $imagefile =  $row[2];
  }
  print "<div class=\"answer\" align=\"CENTER\">�������������� ���������.</div><br>";
  print "<form method=\"POST\" onsubmit=\"document.getElementById('idsave').value='���������';\">";
  print "</b>������������ ���������</b><br>";
  print "<input type=\"TEXT\" name=\"name\" size=\"25\" maxlength=\"25\" value=\"$name\"><br>";
    print "<b>����������� ���������</b>:<br>";
  $url = $_SERVER['DOCUMENT_ROOT']."/".getUri()._UploadDir;
  print "<select name='imagefile' style='width:400px'>";
  $AllFilesList = LoadFromDir($url);
  foreach($AllFilesList as $file){
      if ($imagefile==$file[0])
          $imgSelected = 'SELECTED';
      else
          $imgSelected = '';
    print "<option value='{$file[0]}' $imgSelected >{$file[0]}</option>";
  }
  print "</select>";
  print "<br><b>�������� ���������:</b><br>";
  print "<textarea name='descr' cols=\"80\" rows=\"15\">$descr</textarea><br>";
  
  print "<input type=\"HIDDEN\" name=\"id\" value=\"$id\">";
  print "<input type=\"HIDDEN\" name=\"action\" value=\"addresult\">";
  print "<input type=\"HIDDEN\" name=\"show\" value=\"parts\">";
  print "<input type=\"HIDDEN\" id=\"idsave\" name=\"issave\" value=\"1\">";
  print "<input type=\"SUBMIT\"  name=\"save\" value=\"���������\">";
  print "</form>";
  }
  else
  {
    $pname=addslashes($name);
    $pdescr=addslashes($descr);
    if ($pname=="")
      $pname="�� �������";
    if ($id=="")
    {
      $ord=MaxOrd("em_category","");
      $ord++;
      $result=mQuery("INSERT INTO em_category(name,ordinal, description, imagefile) VALUES('$pname',$ord, '$pdescr', '$imagefile')");
    }
    else
    {
       $result=mQuery("UPDATE em_category SET name='$pname',description='$pdescr',imagefile='$imagefile' WHERE id=$id");
    }
  }

}

#������� ������������� ���������� news
function EditNews($id)
{
  global $name,$issave,$news,$metadescr,$metawords;
  if($issave=="")
  {
  $pname="";                                                          
  if ($id!="")
  {
    $result=mQuery("SELECT name,news,ndate,metadescription,metakeywords FROM news WHERE id=$id");
    $row=mysql_fetch_array($result);
    $name=stripslashes($row[0]);
    $news=stripslashes($row[1]);
    $ndate=$row[2];
    $metadescr=stripslashes($row[3]);
    $metawords=stripslashes($row[4]);    
  }
  else
  {

  }
  print "<div class=\"answer\" align=\"CENTER\">�������������� �������.</div><br>";
  print "<form method=\"POST\" onsubmit=\"document.getElementById('idsave').value='���������';\">";
  print "<b>��������� �������</b><br>";
  print "<input type=\"TEXT\" name=\"name\" size=\"40\" maxlength=\"50\" value=\"$name\"><br>";
  printMetaInput($metadescr,$metawords);
  
  print "<b>����� (HTML ���) �������.</b><br>";
  print "<textarea name=\"news\" cols=\"140\" rows=\"30\">$news</textarea><br>";
  print "<input type=\"HIDDEN\" name=\"id\" value=\"$id\">";
  print "<input type=\"HIDDEN\" name=\"action\" value=\"addresult\">";
  print "<input type=\"HIDDEN\" name=\"show\" value=\"news\">";
  print "<input type=\"HIDDEN\" id=\"idsave\" name=\"issave\" value=\"1\">";
  if ($id!="")
     print "<font size=\"2\">��������� �������� ������� <b>$ndate</b></font><br>";
  print "<input type=\"SUBMIT\"  name=\"save\" value=\"���������\">";
  print "</form>";
  }
  else
  {
    $nname=$name;
    if ($nname=="")
      return "��������� ������� �� ������!";
    $ndate=date('Y-m-d H:i:s');
    $name=addslashes($name);
    $news = parseImg($news);
    $news=addslashes($news);
    if ($id=="")
    {
      $ord=MaxOrd("parts","");
      $ord++;
      $result=mQuery("INSERT INTO news(ndate,name,news, metadescription, metakeywords) 
                      VALUES('$ndate','$name', '$news','$metadescr','$metawords')");
    }
    else
    {
       $result=mQuery("UPDATE news SET name='$name', news='$news', ndate='$ndate' ,
                       metadescription = '$metadescr', 
                       metakeywords = '$metawords'
                       WHERE id=$id");
    }
  }

}
#������� ������������� ���������� news
function EditGoods($id)
{
  global $name,$issave,$goods,$category,$price,$metadescr,$metawords,$imagefile;
  if($issave=="")
  {
  $pname="";
  if ($id!="")
  {
    $result=mQuery("SELECT name,description,price,categoryId,metadescription,metakeywords,imagefile FROM em_goods WHERE id=$id");
    $row=mysql_fetch_array($result);
    $name=stripslashes($row[0]);
    $goods=stripslashes($row[1]);
    $price = $row[2];
    $category = $row[3];
    $metadescr=stripslashes($row[4]);
    $metawords=stripslashes($row[5]);    
    $imagefile = $row[6];
  }
  else
  {

  }
  print "<div class=\"answer\" align=\"CENTER\">�������������� ������������ ������.</div><br>";
  print "<form method=\"POST\" onsubmit=\"document.getElementById('idsave').value='���������';\">";
  print "<b>������������ ������:</b><br>"; 
  print "<input type=\"TEXT\" name=\"name\" size=\"40\" maxlength=\"50\" value=\"$name\"><br>"; 
  #���������
  print "<b>��������� ������:</b><br>";
  print "<select name = 'category'>";
  $res = mQuery("SELECT id,name FROM em_category order by ordinal");
  while($row=mysql_fetch_row($res))
  {
      if ($row[0]==$category)
        $sel = 'SELECTED';
      else
        $sel = '';
      print "<option $sel value={$row[0]}>{$row[1]}";
  }    
  print "</select><br>";
  print "<b>��������� ������:</b><br>";
  print "<input type=\"TEXT\" name=\"price\" size=\"40\" maxlength=\"50\" value=\"{$price}\"><br>";
  printMetaInput($metadescr,$metawords);       
  print "<b>����������� ������</b>:<br>";
  $url = $_SERVER['DOCUMENT_ROOT']."/".getUri()._UploadDir;
  print "<select name='imagefile' style='width:400px'>";
  $AllFilesList = LoadFromDir($url);
  foreach($AllFilesList as $file){
      if ($imagefile==$file[0])
          $imgSelected = 'SELECTED';
      else
          $imgSelected = '';
    print "<option value='{$file[0]}' $imgSelected>{$file[0]}";
  }
  print "</select><br>";
  print "<b>�������� ������.</b><br>";
  print "<textarea name=\"goods\" cols=\"140\" rows=\"30\">$goods</textarea><br>";  
  print "<input type=\"HIDDEN\" name=\"id\" value=\"$id\">";
  print "<input type=\"HIDDEN\" name=\"action\" value=\"addresult\">";
  print "<input type=\"HIDDEN\" name=\"show\" value=\"goods\">";
  print "<input type=\"HIDDEN\" id=\"idsave\" name=\"issave\" value=\"1\">";
  print "<input type=\"SUBMIT\"  name=\"save\" value=\"���������\">";
  print "</form>";
  }
  else
  {
    $nname=$name;
    if ($nname=="")
      return "������������� ������ �� �������!";
    $ndate=date('Y-m-d H:i:s');
    $name=addslashes($name);
    $goods = parseImg($goods);
    $goods=addslashes($goods);
    if ($id=="")                 
    {
      $ord=MaxOrd("em_goods","");
      $ord++;
      $result=mQuery("INSERT INTO em_goods(categoryid,name,description,price,ordinal, metadescription, metakeywords,imagefile) 
                      VALUES('$category','$name', '$goods','$price','$ord','$metadescr','$metawords','$imagefile')");
    }
    else
    {
       $result=mQuery("UPDATE em_goods SET categoryid = '$category', name='$name', description='$goods', price='$price' ,
                       metadescription = '$metadescr', 
                       metakeywords = '$metawords',
                       imagefile = '$imagefile' 
                       WHERE id=$id");
    }
  }

}
function CopyGoods($gid)
{                    
    $res = mQuery("INSERT INTO em_goods( categoryid,name,description,price,ordinal)
                  SELECT categoryid,name,description,price,(select max(ordinal+1) from em_goods)
                  FROM em_goods WHERE ID = $gid");
}
#������� ������������� ���������� pages
function EditPages($id)
{
  global $name,$issave,$page,$descr,$pid,$pidsel,$metadescr,$metawords;
  if($issave=="")
  {
  $pname="";
  if ($id!="")
  {
    $result=mQuery("SELECT name,page,descr,pdate,metadescription,metakeywords FROM pages WHERE id=$id");
    $row=mysql_fetch_array($result);
    $name=stripslashes($row[0]);
    $page=stripslashes($row[1]);
    $descr=stripslashes($row[2]);
    $metadescr=stripslashes($row[4]);
    $metawords=stripslashes($row[5]);
    $pdate=$row[3];
  }
  else
  {

  }

  
  print "<div class=\"answer\" align=\"CENTER\">�������������� ��������.</div><br>";

  print "<form method=\"POST\" onsubmit=\"document.getElementById('idsave').value='���������';\">";
  print"<b>������:&nbsp;</b>";
  print"<select id=\"idsel\" name=\"pidsel\">";
  $result=mQuery("SELECT id,name FROM parts ORDER BY ordinal");

  while ($row=mysql_fetch_array($result))
  {
     if($row[0]==$pid)
       print "<option value=\"$row[0]\" SELECTED>$row[1] ";
     else
       print "<option value=\"$row[0]\">$row[1] ";

  }
   print "</select><br><br>";
  //print " <br><br>";
  print "<b>�������� ��������:</b><br>";
  print "<input type=\"TEXT\" name=\"name\" size=\"40\" maxlength=\"50\" value=\"$name\"><br>";
  print "<b>��������� ��������:</b><br>";
  print "<input type=\"TEXT\" name=\"descr\" size=\"100\" maxlength=\"150\" value=\"$descr\"><br>";
  #print "<textarea name=\"descr\" cols=\"70\" rows=\"15\">$descr</textarea><br>";
  print "<b>�������� �������� ��� ���c����� �����</b>";
  printMetaInput($metadescr,$metawords);


  print "<input type=\"CHECKBOX\" name='isinclude' onclick=\"alert(this.value);\">���������� ������<br>";
  print "<textarea name=\"page\" cols=\"140\" rows=\"30\">$page</textarea><br>";
  print "<input type=\"HIDDEN\" name=\"id\" value=\"$id\">";
  print "<input type=\"HIDDEN\" name=\"action\" value=\"addresult\">";
 // print "<input type=\"HIDDEN\" id=\"idpid\"  name=\"pid\" value=\"$pid\">";
  print "<input type=\"HIDDEN\" name=\"show\" value=\"info\">";
  print "<input type=\"HIDDEN\" id=\"idsave\" name=\"issave\" value=\"1\">";
  if ($id!="")
     print "<font size=\"2\">��������� �������� �������� <b>$ndate</b></font><br>";
  print "<input type=\"SUBMIT\"  name=\"save\" value=\"���������\">";
  print "</form>";
  }
  else
  {
    $name=addslashes($name);
    $descr=addslashes($descr);
    $page = parseImg($page); 
    $page=addslashes($page);
    $metadescr=addslashes($metadescr);
    $metawords=addslashes($metawords);
    $isinclude =  addslashes($_POST['isinclude']);
    if ($isinclude != "")
        $isinclude = "1";
    else
        $isinclude = "0";
    if ($name=="")
      return "�������� �������� �� �������!";
    if ($descr=="")
      return "��������� �������� �� ������!";
    $pdate=date('Y-m-d H:i:s');

    if ($id=="")
    {
      $ord=MaxOrd("pages",$pid);
      $ord++;
      $result=mQuery("INSERT INTO pages(pdate,name,descr,page, pid,ordinal, isinclude,metadescription, metakeywords) 
                      VALUES('$pdate','$name', '$descr', '$page', '$pidsel', '$ord', '$isinclude', '$metadescr', '$metawords')");
    }
    else
    {
       $result=mQuery("UPDATE pages SET name='$name', descr='$descr', page='$page', pdate='$pdate', pid='$pidsel', isinclude='$isinclude',
                       metadescription='$metadescr',
                       metakeywords='$metawords'
                       WHERE id=$id");
    }
  }

}

#������� ������������� ���������� Ask
function EditAsk($id)
{
  global $issave,$answer;
  if($issave=="")
  {
  if ($id!="")
  {
    $result=mQuery("SELECT qname,quetion,answer,email,qdate FROM ask WHERE id=$id");
    $row=mysql_fetch_array($result);
    $name=stripslashes($row[0]);
    $quetion=stripslashes($row[1]);
    $answer=stripslashes($row[2]);
    $email=stripslashes($row[3]);
    $qdate=$row[4];
  }
  else
  {

  }
  print "<div class=\"answer\" align=\"CENTER\">�������������� �������.</div><br>";
  print "<form method=\"POST\" onsubmit=\"document.getElementById('idsave').value='���������';\">";
  print "<b>�����������:</b> $name<br> ";
  print "<b>������.</b><br>";
  print "<div class=\"quetion\" >$quetion</div><br>";
  print "<div align='RIGHT'><font size=\"2\">$qdate</font></div> ";

  print "<b>�����.</b><br>";
  print "<textarea name=\"answer\" cols=\"140\" rows=\"30\">$answer</textarea><br>";
  print "<input type=\"HIDDEN\" name=\"id\" value=\"$id\">";
  print "<input type=\"HIDDEN\" name=\"action\" value=\"addresult\">";
  print "<input type=\"HIDDEN\" name=\"show\" value=\"ask\">";
  print "<input type=\"HIDDEN\" id=\"idsave\" name=\"issave\" value=\"1\">";

 print "<input type='CHECKBOX' CHECKED name='ismail'>";
 print "<b>����������� ����� �� email ����������� </b><br>";

  print "<input type=\"SUBMIT\"  name=\"save\" value=\"���������\">";
  print "</form>";
  }
  else
  {
    if ($answer=="")
      return "����� �� ������ �� ���!";
    $qdate=date('Y-m-d H:i:s');
    $answer=addslashes($answer);
     
    $result=mQuery("UPDATE ask SET answer='$answer', qdate='$qdate' WHERE id=$id");
    $res = mQuery("SELECT email,quetion FROM ask WHERE id=$id");
    if ($row = mysql_fetch_row($res)){
        if (!empty($row[0])){
            require_once "../modules/em/usercommunication.php"; 
            //include "../libs/init_settings_var.php";
            $comminc = new UserCommunication();
            $comminc->init();
            $subject = "����� �� ��� ������, ����������� �� �����".getHost();
            $msg = "��� ������: \"$row[1]\". \n\r
            �����: $answer.\n\r
            �����, ����� �� ������ ������� �� ����� � ������� �������.\n\r 
            � ���������,
            ��������-������� ".getHost();
            $comminc->sendMailFmooManager($row[0],$subject,$msg );
        }
    }

  }

}
#������� ������������� ���������� parts
function EditOrders($id)
{
  global $managerdesc,$iscomplete,$issave;
  if($issave=="")
  {
  $pname="";
  if ($id!="")
  {
    $result=mQuery("SELECT o.id,o.goodsId,o.date,o.iscomlete,o.datecomplete,CONCAT(o.firstname,' ',lastname) as FIO,tel,email,adres,o.description,o.managerdesc,goodsprice, userId, totalsum, discount
                FROM em_order o
                WHERE o.id = $id");    
    $row=mysql_fetch_array($result);
    $pname=$row[0];
  }
  print "<div class=\"answer\" align=\"CENTER\">��������� ������.</div><br>";
  print "<form method=\"POST\" onsubmit=\"document.getElementById('idsave').value='���������';\">";
  print "<table border = 1 'width=500'>";
  print "<tr>";
  print "<td 'width=100'>";
  print "<b>����� �</b>";
  print "</td>";
  print "<td 'width=300'>";
  print "$row[0]";
  print "</td>";  
  print "</tr>";
  
  print "<tr>";
  print "<td 'width=100'>";
  print "<b>����. ������</b>";
  print "</td>";
  print "<td 'width=300'>";
  $sum = 0;
  if ($row[1] == null){
      $chGoods = mQuery("SELECT goodsid, cnt,goodsprice FROM em_order where id_parent=$id");
      while($item=mysql_fetch_array($chGoods)){
          $goods = new Goods($item[0]);
        echo "<a href='".GetHost()."?show=goodsone&id={$goods->id}'>{$goods->name}</a> {$item[1]} ��. x {$item[2]}</br>";    
        $sum += $item[1]*$item[2];
      }
  }else{
      $goods= new Goods($row[1]);
      echo "<a href='".GetHost()."?show=goodsone&id={$goods->id}'>{$goods->name}</a>";
      $sum = $row[11];
  }
  print "</td>";  
  print "</tr>"; 
   
  print "<tr>";
  print "<td 'width=100'>";
  print "<b>����� ������</b>";
  print "</td>";
  print "<td 'width=300'>";
  print "$sum";
  print "</td>";  
  print "</tr>";
  
  print "<tr>";
  print "<td 'width=100'>";
  print "<b>������</b>";
  print "</td>";
  print "<td 'width=300'>";
  print "{$row[14]}%";
  print "</td>";  
  print "</tr>";
  
  print "<tr>";
  print "<td 'width=100'>";
  print "<b>����� �� �������</b>";
  print "</td>";
  print "<td 'width=300'>";
  print "{$row[13]}";
  print "</td>";  
  print "</tr>";

  print "<tr>";
  print "<td 'width=100'>";
  print "<b>���� ������</b>";
  print "</td>";
  print "<td 'width=300'>";
  print "$row[2]";
  print "</td>";  
  print "</tr>";
  if (($row[12]=="")||($row[12]=="0")){
  print "<tr>";
  print "<td 'width=100'>";
  print "<b>��� ���������</b>";
  print "</td>";
  print "<td 'width=300'>";
  print "$row[5]";
  print "</td>";  
  print "</tr>";
    
  print "<tr>";
  print "<td 'width=100'>";
  print "<b>�������</b>";
  print "</td>";
  print "<td 'width=300'>";
  print "$row[6]";
  print "</td>";  
  print "</tr>";
            
  print "<tr>";
  print "<td 'width=100'>";
  print "<b>email</b>";
  print "</td>";
  print "<td 'width=300'>";
  print"<a href='mailto:$row[7]'>$row[7]</a>"; 
  print "</td>";  
  print "</tr>";
  }
  else{
    print "<tr>";
    print "<td 'width=100'>";
    print "<b>��������</b>";
    print "</td>";
    print "<td 'width=300'>";
    $acc_view = new CabinetViewer($row[12]);
    print $acc_view->getAccountAbout(); 
    print "</td>";  
    print "</tr>";      
  }  
  print "<tr>";
  print "<td 'width=100'>";
  print "<b>������</b>";
  print "</td>";
  print "<td 'width=300'>";
  if ($row[3]==1)
    $state = "��������� $row[4]&nbsp;&nbsp;&nbsp;<input type='CHECKBOX' checked name='iscomplete'>";
  else
    $state = "���������:&nbsp;&nbsp;&nbsp;<input type='CHECKBOX' name='iscomplete'>";
  print "$state";
  print "</td>";  
  print "</tr>";  
  
  print "<tr>";
  print "<td 'width=100'>";
  print "<b>��������</b>";
  print "</td>";
  print "<td 'width=300'>";
  //print "$row[8]";
  print getDeliveryInfo($row[8], $row[2]);
  print "</td>";  
  print "</tr>";

  print "<tr>";
  print "<td 'width=100'>";
  print "<b>����������</b>";
  print "</td>";
  print "<td 'width=300'>";
  print "$row[9]";
  print "</td>";  
  print "</tr>"; 
  
  print "<tr>";
  print "<td 'width=100'>";
  print "<b>������ �������</b>";
  print "</td>";
  print "<td 'width=300'>";
  print "<textarea name='managerdesc' cols=100 rows=10>$row[10]</textarea>";
  print "</td>";  
  print "</tr>";   
    
  print "</table>";
  
  print "<input type=\"HIDDEN\" name=\"id\" value=\"$id\">";
  print "<input type=\"HIDDEN\" name=\"action\" value=\"addresult\">";
  print "<input type=\"HIDDEN\" name=\"show\" value=\"parts\">";
  print "<input type=\"HIDDEN\" id=\"idsave\" name=\"issave\" value=\"1\">";
  print "<input type=\"SUBMIT\"  name=\"save\" value=\"���������\">";
  print "</form>";
  }
  else
  {      
      $managerdesc=addslashes($managerdesc);
      $res = mQuery("SELECT iscomlete FROM em_order where id=$id");
      $row=mysql_fetch_row($res);

      if (($iscomplete=="") && ($row[0]==1))
      {
        $iscomplPart= ", iscomlete = 0, dateComplete=NULL ";
      }                                             
      else
      if (($iscomplete!="") && ($row[0]==1))
      {
        $iscomplPart= "";
      }
      else
      if (($iscomplete!="") && ($row[0]==0))
      {
        $iscomplPart= ", iscomlete = 1, dateComplete=now() ";
      }
      
      if ($id!="") 
      {
         $result=mQuery("UPDATE em_order SET managerdesc='$managerdesc' $iscomplPart WHERE id=$id");
      }
  }

}

function getDeliveryInfo($info, $orderDate){
    $info = iconv("windows-1251", "UTF-8", $info);
    $info = json_decode(htmlspecialchars_decode($info));
    //var_dump($info);
    switch($info->method){
        case 3:
            return getCurrierDelivery($info, $orderDate);
        case 2:
            return getPVZDelivery($info, $orderDate);
        case 1:
            return getSelfDelivery($info);
    }
}

function getCurrierDelivery($info, $orderDate){
    $res = "<b>������ ������:</b> <u>�������� ��������</u><br>";
    $res .= "<b>�����:</b> {$info->index}, {$info->city}, {$info->address}<br>";
    $res .= "<b>��������� ��������:</b> {$info->curr->price}<br>";
    $orderDate = new DateTime($orderDate);
    $orderDate->modify("+{$info->curr->delivery_period} day");
    $res .= "<b>���� ��������:</b> {$info->curr->delivery_period} ��.  ({$orderDate->format('Y-m-d')})<br>";
    return $res;
}

function getPVZDelivery($info, $orderDate){
    $res = "<b>������ ������:</b> <u>�������� � ����� ������ � {$info->pvzId->id}</u><br>";
    //$city = iconv("UTF-8", "windows-1251", $info->pvzId->name); 
    $address = iconv("UTF-8", "windows-1251", $info->pvzId->address); 
    $res .= "<b>����� ���:</b> $address <br>";
    $res .= "<b>�������:</b> {$info->pvzId->phone} <br>";
    $workschedule = iconv("UTF-8", "windows-1251", $info->pvzId->workschedule); 
    $res .= "<b>������ ������:</b> $workschedule <br>";
    $res .= "<b>������ ��������������:</b> {$info->pvzId->prepaid} <br>";                                
    $res .= "<b>��������� ��������:</b> {$info->pvzId->price} <br>";
    $orderDate = new DateTime($orderDate);
    $orderDate->modify("+{$info->pvzId->period} day");
    $res .= "<b>���� ��������:</b> {$info->pvzId->period} ��.  ({$orderDate->format('Y-m-d')})<br>";
    return $res;
}
function getSelfDelivery($info){
    $res = "<b>������ ������:</b> <u>��������� �� ������</u><br>";
    return $res;
}
#������� ������������� ���������� pages
function EditFile($id)
{
  global $name,$issave,$page,$descr,$pid,$pidsel,$PGath,$action;
  if($issave=="")
  //if(strtolower($action)=="add")
  {
  $pname="";
  print "<div class=\"answer\" align=\"CENTER\">�������������� ����������.</div><br>";

  print "<form enctype=\"multipart/form-data\" method=\"POST\" onsubmit=\"document.getElementById('idsave').value='���������'; \">";
  //print " <br><br>";

  print "<b>����</b><br>";
  print " <input type=file name=path><br>";
  print "<b>����� ��� �����:</b><br>";
  print "<input type=\"TEXT\" name=\"name\" size=\"40\" maxlength=\"50\" value=\"$name\"><br>";
  #print "<textarea name=\"descr\" cols=\"70\" rows=\"15\">$descr</textarea><br>";
  print "<input type=\"HIDDEN\" name=\"id\" value=\"$id\">";
  print "<input type=\"HIDDEN\" name=\"action\" value=\"addresult\">";
 // print "<input type=\"HIDDEN\" id=\"idpid\"  name=\"pid\" value=\"$pid\">";
  print "<input type=\"HIDDEN\" name=\"show\" value=\"upload\">";
  print "<input type=\"HIDDEN\" id=\"idsave\" name=\"issave\" value=\"1\">";
  print "<input type=\"SUBMIT\"  name=\"save\" value=\"���������\">";
  print "</form>";
  }
  else
  //if(strtolower($action)=="addresult")
  {
    if(!is_uploaded_file($_FILES['path']['tmp_name']))     return "���������� �� ���������!";
    $name=addslashes($name);
    $descr=addslashes($descr);
    $path=$_FILES['path']['name'];
    if ($name=="")
      return "�������� ���������� �� �������!";
    $uri = $_SERVER['REQUEST_URI'];
    $uri = subStr($uri,1);
    $uri = subStr($uri,0,strPos($uri,"/"));
     $fn = $_SERVER['DOCUMENT_ROOT'].'/'.getUri()._UploadDir."/".$name;    
// addLog ($fn);
    copy($_FILES['path']['tmp_name'], $fn);
//copy($_FILES['path']['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/".$uri.'/'._UploadDir."/".$name);
    //$_SESSION['jpeg_file'] = $_SERVER['DOCUMENT_ROOT']."/".$uri.'/'._UploadDir."/".$name;
    global $jpeg_file; 
    global $jpeg_file_newname;
    $jpeg_file_newname = $name;    
/*
    if (subStr(strtolower($name),StrLen($name)-4,StrLen($name)) == '.jpg')
    {
        //$jpeg_file = $_SERVER['DOCUMENT_ROOT']."/".$uri.'/'._UploadDir."/".$name;
$jpeg_file = $_SERVER['DOCUMENT_ROOT'].'/'._UploadDir."/".$name;
$_SESSION['jpeg_file'] = $jpeg_file;
        $_SESSION['jpeg_file_newname'] = $name;    
        include "../libs/convertfoto.php";
    }
*/
  }

}
function deleteFile($fn)
{
    @unlink('../'._UploadDir.'/'.$fn);     
    
}

#���������� �������� ��� ordinal
function MaxOrd($dir,$pid)
{
   if ($pid!="")
     $where=" WHERE pid=$pid ";
   else
     $where="";
   $result=mQuery("SELECT MAX(ordinal) FROM $dir $where ");
   $row=mysql_fetch_array($result);
   return $row[0];
}
#������� �� �������
function deleteRecord($id,$dir)
{
  #������� �����������
  if ($dir=="parts")
  {
    $result=mQuery("SELECT count(id) FROM pages WHERE PID=$id");
    $row=mysql_fetch_array($result);
    if ($row[0]>0)
      return "�� ���� �������� ���������� ��������. ������ ��� ������� ���, ������� ������������ �� ��� ������";
  }
  
  if  (($dir=="pages") && ($id==1)){
    return "������ ������� ������� ��������";
  }
  if ($dir=="em_order"){
    $result=mQuery("select id from em_order where id_parent=$id");
    while($row=mysql_fetch_array($result)){
        $r = mQuery("DELETE from em_order WHERE id={$row[0]}");   
    }
        
  }
  $result=mQuery("DELETE FROM $dir WHERE id=$id");
}

function ViewRegurds($id)
{
   $result=mQuery("SELECT id,rdate, regard,name,firm,position FROM regards WHERE id=$id");
   $row=mysql_fetch_array($result);
    print "<table border=\"0\">";
    print"<tr><td><b>���:</b></td>";
    print"<td>".stripslashes($row[3])."</td></tr>";
    if (stripslashes($row[4])!="")
    {
      print"<tr><td><b>��������:</b></td>";
      print"<td>".stripslashes($row[4])."</td></tr>";
    }
    if (stripslashes($row[5])!="")
    {
      print"<tr><td><b>���������:</b></td>";
      print"<td>".stripslashes($row[5])."</td></tr>";
    }
    print"</table>";
    print "<div class=\"descr\">�����</div><br>";
    print "<div class=\"quetion\">".stripslashes($row[2])."</div>";
    print "<div align=\"RIGHT\">$row[1]</div>";
    print"<a href=\"?show=regards&action=del&id=$row[0]\">������� �����</a>";
}
function LoadFromDir($dir)
{
    $uri = $_SERVER['REQUEST_URI'];
    $uri = subStr($uri,1);
    $uri = subStr($uri,0,strPos($uri,"/"));
    $url = $_SERVER['DOCUMENT_ROOT']."/$uri/"._UploadDir."$dir";
    $url = $dir;
    $url2 = _UploadDir;
    $FilesArr = Array();
    $i=0;
    if (is_dir($url))
    {
    if ($dir = opendir($url)) 
    { 
        while (false !== ($file = readdir($dir)))
        {
            if (($file != ".") && ($file != ".."))
            {
                if (is_dir("$url/$file"))
                    continue;
                else
                { 
                    //UploadBLOBtrfFile("$url/$file");
                    $FilesArr[$i][0] ="$url/$file"; 
                    $FilesArr[$i][1] ="$file";
                    $FilesArr[$i][2] ="$url2/$file";   
                    $i++;
                }
            }
        }
    }      
    return $FilesArr;
    }
else
    $_SESSION['sysmsg'] .="�� ������� ����� ����� <b>$url</b>";
        
}
function getAttribs($t, $a, $s) {
    
    preg_match_all('/<img.*?getsmall.php.*?>/', $s, $matches);         
    return $matches[0];
}
function parseImg($content)
{
 //   $content = "<img src='getsmall.php?imgname=uploadfiles/smile.jpg'><img src='getsmall.php?imgname=uploadfiles/squre.jpg'><img src='evil.jpg'><br>";    
    $arr=getAttribs('img', 'src', $content);  
    //print "<br>";
    foreach ( $arr  as $a)
    {        
        $src = $a;
        $a = trim($a);
        $VarName = '?imgname=';
        $ImgFile = "getsmall.php$VarName";
        $FileT = '.jpg';
        $StartFrom =  strPos($a,$VarName)+StrLen($VarName);
        $Till =   strPos($a,$FileT) - $StartFrom +  StrLen($FileT);
        $ImgName = subStr($a, $StartFrom,$Till);        
        //$a = subStr($a, 0, Strlen($a)-2). " onClick=\" initImg('".str_replace('/adm/','',GetHost())._domen."','$ImgName','smallimg',0,0); ShowDiv('smallplace') \">";
        $a = subStr($a, 0, Strlen($a)-2). " onClick=\" initImg('".str_replace('/adm/','',GetHost())."','$ImgName','smallimg',0,0); ShowDiv('smallplace') \">";
        $content = str_replace($src,$a, $content);        
    }
    return $content;    
}
function printMetaInput($metadescr,$metawords)
{
  print "<b>�������� �������� ��� ���c����� �����</b><br>";
  print "<textarea  name='metadescr' cols=40 rows=5>";
  print "$metadescr";
  print "</textarea><br>";
  print "<b>�������� ��� ���c����� �����</b> (������������ ����� �������):<br>";
  print "<input type=text  name='metawords' size=59  maxlength=255 value = \"$metawords\"><br><br>";    
} 

#������� ������������� ���������
function EditSettings(){
    $res = mQuery("SELECT id, description FROM settings");
    while ($row = mysql_fetch_row($res)){
        if (isset($_POST['set_'.$row[0]])){
            $result = mQuery("UPDATE settings SET value='".htmlspecialchars($_POST['set_'.$row[0]])."' WHERE id = '$row[0]'");            
        }    
    }
    
} 

function getJSConst(){
    return "<script> 
                var host='".getHost()."';
                var modalAlertPlace='"._MODAL_ALERT_PLC."';
             </script>";
}

   
?>