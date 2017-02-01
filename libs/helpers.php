<?php

function ShowData($show,$id)
{
  global $show,$qname,$isSend,$cd,$qtext,$email;
  global $rname,$firm,$position,$rcd,$isrsend,$rtext,$stext,$smode;
  global $mesid,$issave,$ShortCntGoods;
  #выясняю что, и из какой таблицы тянуть информацию
  switch ($show)
  {
    case "info":
         $fieldList=" p.name, p.descr, p.page,p.pdate, p.isinclude FROM pages p ";
         $result=mQuery("SELECT $fieldList where id=$id");
         $row=mysql_fetch_array($result);
         #вывод заголовка
         print "<div align=\"CENTER\" class=\"descr\">".stripslashes($row[1])."</div><br>";
         if ($row[4]=='0')
          {
           #вывод самой статьи
            print stripslashes($row[2]);
            #вывод даты
            #print "<div align=\"RIGHT\" class=\"pdate\">$row[3]</div>";
           }
     /*    else
          #подключаю скрипт
          include $row[2];
     */

    break;
    case "ask":
         $fieldList=" a.qdate, a.qname, a.quetion, a.answer FROM ask a ";
         $result=mQuery("SELECT $fieldList where id=$id");
         $row=mysql_fetch_array($result);
         #Вывод имени даты
         print "<div class=\"asker\">$row[1] <font size=\"2\">$row[0]</font></div><br>";
         #вывод вопроса
         print "<div align=\"LEFT\"><b>Вопрос:</b></div>";
         print "<div class=\"quetion\">";
         print stripslashes($row[2]);
         print "</div><br>";
         #вывод ответа
         print "<div align=\"LEFT\"><b>Ответ:</b></div>";
         print "<div class=\"ansver\">";
         print stripslashes($row[3]);
         print "</div><br>";

    break;
    case "news":
         $fieldList=" n.ndate, n.name, n.news FROM news n ";
         $result=mQuery("SELECT $fieldList where id=$id");
         $row=mysql_fetch_array($result);
         #вывод заголовка
         print "<div align=\"CENTER\" class=\"descr\"\\\>".stripslashes($row[1])."</div><br>";
         #вывод самой новости
         print stripslashes($row[2]);
         #вывод даты
         print "<div align=\"RIGHT\" class=\"pdate\">$row[0]</div>";
    break;
    case "goods":
         $result=mQuery("SELECT g.id,g.name,g.description,g.price,c.name 
                         from em_goods g, em_category c 
                         where g.categoryid = c.id AND g.id=$id");
         $row=mysql_fetch_array($result);
         #вывод заголовка                                
         print "<div align=\"CENTER\" class=\"descr\"\\\><b>".stripslashes($row[1])."</b></div><br>";
         #вывод описанея
         print stripslashes($row[2]);
         #вывод цены                                
         print "<div align=\"LEFT\" class=\"pdate\">";
         print "<i>Цена: $row[3] р.</i>";
         print "</div>";
         include "scripts/order.php";
    break;   
    case "catalog":
         print "<div align = 'CENTER'>";

         print "<h2>Каталог продукции</h2><br>";
         print "</div>";
         if ($id!='')
         {
            $categPart = "WHERE c.id = $id";
            $goodsLimit = 100000;
         }
         else
         {
             $categPart = "";
             $goodsLimit = $ShortCntGoods;
         }
         $result=mQuery("SELECT id, name, (SELECT count( * )
                        FROM em_goods
                        WHERE categoryId = c.id)
                        FROM em_category c
                        $categPart
                        ORDER BY ordinal");

         print "<table border=0>";
        
         while($row=mysql_fetch_array($result))
         {
            print "<tr>";
                print "<td>";
                    print "<table border=0 'width=100%'>";
                        print "<tr>";
                            print "<td width='200'>";
                                print "<a href='?show=catalog&id=$row[0]'><font color='#FF0000'><b>$row[1]</b></font></a>";
                            print "</td>";
                            print "<td>"; 
                                print "<i>всего $row[2] наим.</i>";
                            print "</td>";
                        print "</tr>";
                    print "</table>";
                print "</td>";
            print "</tr>";            
            $res = mQuery("SELECT id,name,'',price FROM em_goods WHERE categoryid = $row[0] order by ordinal LIMIT 0,$goodsLimit ");
            print "<tr>";
            print "<td>";
            print "<table border=\"0\" width=\"300px\">";
            $cnt=0;
             
            while ($r = mysql_fetch_row($res))
            {      
                $cnt++;
                print "<tr>";   

                
                    print "<td>"; 
                        print "<a href='?show=goods&id=$r[0]' alt=''><li><i>$r[1]</i></li></a>";  
                    print "</td>"; 
  
                    print "<td>"; 
                        print "<i>$r[3] р.</i>";  
                    print "</td>";                 
                    
                print "</tr>";   
            }
              
            if ($cnt<$row[2])
            {
            print "<tr>";
                print "<td>";
                    print "<a href = '?show=catalog&id=$row[0]'>еще..</a>";
                print "</td>";
                print "<td>";
                print "</td>";
            print "</tr>";
            }
            print "</table>";
            print "</td>";
            print "</tr>";

         } 
                 
         print "</table>";
    break;     

    case "regards":
        ShowRegard($id);
    break;
    case "allnews":
         showAllNews();
    break;
    case "allask":
         showAllAsk();
    break;
    case "quetion":
         include "quetion.php";
    break;
    case "allregards":
         showAllregards();
    break;
    case "addregard":
         include "addregard.php";
    break;
    case "search":
         search($stext,$smode);
    break;
    case "message":
        //print "$InfoMessage";
        switch ($mesid)
        {
            case "ordersuccessfully":
                $infomessgae = "</b>Заказ принят. <br>В ближайшее время с Вами свяжется наш менеджер.</b>";
            break;
        }        
        print $infomessgae;
    break;
  }

}

#функция выводящая перечень ссылок h
function hrefList()
{
  $result=mQuery("SELECT  pr.name,pr.id as parentId FROM  parts pr WHERE (SELECT COUNT(id) FROM pages WHERE pid=pr.id)>0 ORDER BY pr.ordinal");
  $ParentId='';
  $LastParentId='';
  $isOtstup=0;
  $otstup="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
  print "<table border=0 cellspacing=\"0\"  width=\"218\" >";

     print "<tr>";
     print "  <td  height=\"52\"  width=\"218\" valign=\"bottom\" background=\"images/blf_08.jpg\" >&nbsp;";
     print "  </td>";
     print "</tr>";
     print "<tr><td align='CENTER' valign=\"top\" background=\"images/blf_13.jpg\"  >";
     print "<font face=\"Verdana\" size=\"2\" color=\"black\"><b>Меню</b></font>";
     print "</td></tr>";
     print "<tr><td valign=\"top\" background=\"images/blf_13.jpg\"  >";
    print "<table cellpadding=\"0\" ><tr><td>";
  while ($row=mysql_fetch_array($result))
  {
     print "<ul type=\"square\"";
     print"<div class=\"parts\">$row[0]</div>";
     $res=mQuery("SELECT  pg.id, pg.name,pg.descr FROM pages pg WHERE pid=$row[1] ORDER BY  pg.ordinal");
     while($r=mysql_fetch_array($res))
     {
       #вывод подраздела меню
       print"<li><div class=\"pages\">  <a href=\"?show=info&id=$r[0]\" class=\"hpages\">$r[1]</a> </div></li> ";
      }
      print "</ul>";
  }

  print "<ul type=\"square\"";
 print"<p><a class=\"hnews\" href='?show=allregards'>Отзывы&Предложения</a></p>";
 print "</ul>";

 print "</td></tr></table>";
  print "</td></tr>";
     print "<tr>";
     print "  <td valign=\"bottom\" height=\"31\"  width=\"218\"  background=\"images/blf_14.jpg\" >&nbsp;";
     print "  </td>";
     print "</tr>";
  print "</table>";
}
function getAllNewsHref()
{
    return "<div align=\"CENTER\" ><a class=\"hnews\" href=\"?show=allnews\">Новости</a></div>";  
}
#функция выводящая список новостей news
function newsList($npage,$ToNews,$isMain)
{
//    if ($isMain==1)
//      print getAllNewsHref();
    $p=($npage-1)*$ToNews;
    if ($p<0) $p=0;
   global $NewsPartLen;
   $result=mQuery("SELECT id,name,news,ndate FROM news ORDER BY ndate DESC LIMIT $p, $ToNews");

  while($row=mysql_fetch_array($result))
  {
    print "<br><a href=\"?show=news&id=$row[0]&npage=$npage\" class=\"hnews\">".stripslashes($row[1])."</a> <font size=\"2\"> $row[3]</font> ";

    #вывожу часть новости
    $row[2] = strip_tags($row[2]);
    $row[2]=stripslashes($row[2]);
    
    $NewsPart=substr($row[2],0,$NewsPartLen)."...";
    print "<div class=\"pnews\">$NewsPart</div>";
    if ($isMain==1)
       print "<hr>";
  }
  return;
}

#функция выводящая весь список новостей
function showAllNews()
{
  global $npage;
  global $AllnewsCount;
  newsList($npage,$AllnewsCount,1);
  print "<br>";
   #вывожу постраничный вывод новостей
  $result=mQuery("SELECT count(id) FROM news");
  $row=mysql_fetch_array($result);
  $pcnt=ceil($row[0]/$AllnewsCount);
  if ($p=0) $p=1;
  for($i=1; $i<=$pcnt;$i++)
  {
   $ii=$i-1;
   if ($i!=$npage)
      print"<a href='?show=allnews&npage=$i'>$i</a>&nbsp;&nbsp;";
   else
       print"$i&nbsp;&nbsp;";
  }
}

#функция выводящая список вопросов
function askList($apage,$ToAsk,$isMain)
{
    print"<div align=\"CENTER\"><a href=\"?show=allask\">Вопрос-ответ</a></div>";
    print"<div align=\"RIGHT\"><a href=\"?show=quetion\">Задать вопрос</a></div>";
    $p=($apage-1)*$ToAsk;
    if ($p<0) $p=0;
    $result=mQuery("SELECT id, quetion,qname FROM ask WHERE answer IS NOT  NULL ORDER BY qdate DESC LIMIT $p, $ToAsk");
    while($row=mysql_fetch_array($result))
    {
       print "<b>".stripslashes($row[2]).":</b><br>";
       print "<div class=\"newspart\">".stripslashes($row[1])."</div>";
       print "<a href=\"?show=ask&id=$row[0]&apage=$apage\" class=\"hnews\"> Ответ</a><br>";
       if ($isMain==1)
        print "<hr>";
    }
}

#фуникция выводящая все вопросы
function showAllAsk()
{
  global $apage;
  global $AllaskCount;
  askList($apage,$AllaskCount,1);
  print "<br>";
   #вывожу постраничный вывод новостей
  $result=mQuery("SELECT count(id) FROM ask WHERE answer IS NOT  NULL");
  $row=mysql_fetch_array($result);
  $pcnt=ceil($row[0]/$AllaskCount);
  if ($p=0) $p=1;
  for($i=1; $i<=$pcnt;$i++)
  {
   if ($i!=$apage)
      print"<a href='?show=allask&apage=$i'>$i</a>&nbsp;&nbsp;";
   else
       print"$i&nbsp;&nbsp;";
  }
}
#функция выводящая список отзывов
function regardsList($rpage,$ToRegards)
{
    print"<div align=\"CENTER\" class=\"descr\">Книга отзывов и предложений</div><br>";
    print"<div align=\"RIGHT\"><a href=\"?show=addregard\">Оставить запись</a></div>";
    $p=($rpage-1)*$ToRegards;
    if ($p<0) $p=0;
   $result=mQuery("SELECT id,name,firm,position,rdate,regard FROM regards ORDER BY rdate DESC LIMIT $p, $ToRegards");

  while($row=mysql_fetch_array($result))
  {
    print "<table border=0>";
    print"<tr><td><b>Имя:</b></td>";
    print"<td>".stripslashes($row[1])."</td></tr>";
    if (stripslashes($row[2])!="")
    {
      print"<tr><td><b>Компания:</b></td>";
      print"<td>".stripslashes($row[2])."</td></tr>";
    }
    if (stripslashes($row[3])!="")
    {
      print"<tr><td><b>Должность:</b></td>";
      print"<td>".stripslashes($row[3])."</td></tr>";
    }
    print "</table>";
    print "<b>Отзыв:</b><br>";
    print"<div class=\"quetion\">".stripslashes($row[5])."</div>";
    print"<div align=\"RIGHT\" class=\"pdate\">".stripslashes($row[4])."</div>";
    print "<hr>";
  }

  return;
}

#функция показывающая отзыв
function  ShowRegard($id)
{
    print"<div align=\"CENTER\" class=\"descr\">Книга отзывов и предложений</div><br>";
    print"<div align=\"RIGHT\"><a href=\"?show=addregard\">Оставить запись</a></div>";
   $result=mQuery("SELECT id,name,firm,position,rdate,regard FROM regards WHERE id=$id");

//  while($row=mysql_fetch_array($result))
 // {
 $row=mysql_fetch_array($result);
    print "<table border=0>";
    print"<tr><td><b>Имя:</b></td>";
    print"<td>".stripslashes($row[1])."</td></tr>";
    if (stripslashes($row[2])!="")
    {
      print"<tr><td><b>Компания:</b></td>";
      print"<td>".stripslashes($row[2])."</td></tr>";
    }
    if (stripslashes($row[3])!="")
    {
      print"<tr><td><b>Должность:</b></td>";
      print"<td>".stripslashes($row[3])."</td></tr>";
    }
    print "</table>";
    print "<b>Отзыв:</b><br>";
    print"<div class=\"quetion\">".stripslashes($row[5])."</div>";
    print"<div align=\"RIGHT\" class=\"pdate\">".stripslashes($row[4])."</div>";
}

#функция выводящая всю книгу отзывов  и предложений
function showAllregards()
{
  global $rpage;
  global $AllregardsCount;
  regardsList($rpage,$AllregardsCount);
  print "<br>";
   #вывожу постраничный вывод новостей
  $result=mQuery("SELECT count(id) FROM regards");
  $row=mysql_fetch_array($result);
  $pcnt=ceil($row[0]/$AllregardsCount);
  if ($p=0) $p=1;
  for($i=1; $i<=$pcnt;$i++)
  {
   $ii=$i-1;
   if ($i!=$rpage)
      print"<a href='?show=allregards&rpage=$i'>$i</a>&nbsp;&nbsp;";
   else
       print"$i&nbsp;&nbsp;";
  }
}

 ### ФУНКЦИИ ПОИСКА ПО САЙТУ#######
 #функция поиска по разделам сайта
 #возвращает массив   id записи  в таблице и название таблицы
 //function partSearch($part,$searchWord)
 function partSearch($part,$searchWord)
 {
    $a=array();
    if (StrLen($searchWord)<=$FullWord)
        $like="\"%$searchWord%\"";
    else
        $like="\"%$searchWord%\"";

    switch ("$part")
    {
        case "info":
           $query=            "SELECT DISTINCT id, 'pages' AS part, 'page' as field, count('%$searchWord%') as cnt, '$searchWord' as searchWord  FROM pages WHERE page LIKE  $like GROUP BY id";
           $query.=" UNION SELECT DISTINCT id, 'pages' AS part, 'name' as field, count('%$searchWord%') as cnt, '$searchWord' as searchWord FROM pages WHERE name LIKE  $like GROUP BY id";
           $query.=" UNION SELECT DISTINCT id, 'pages' AS part, 'descr' as field, count('%$searchWord%') as cnt, '$searchWord' as searchWord FROM pages WHERE descr LIKE  $like GROUP BY id";
           $result=mQuery($query);
           $i=0;
           while ($row=mysql_fetch_array($result))
           {
                $a[$i][0]=$row[0];
                $a[$i][1]=$row[1];
                $a[$i][2]=$row[2];
                $a[$i][3]=$row[3];
                $a[$i][4]=$row[4];
                $i++;
           }
           return $a;
        break;
        case "news":
           $query=            "SELECT DISTINCT id, 'news' AS part, 'news' as field, count('%$searchWord%') as cnt, '$searchWord' as searchWord FROM news WHERE news LIKE  $like GROUP BY id";
           $query.=" UNION SELECT DISTINCT id, 'news' AS part, 'name' as field, count('%$searchWord%') as cnt, '$searchWord' as searchWord FROM news WHERE name LIKE  $like GROUP BY id";
           $result=mQuery($query);
           $i=0;
           while ($row=mysql_fetch_array($result))
           {
                $a[$i][0]=$row[0];
                $a[$i][1]=$row[1];
                $a[$i][2]=$row[2];
                $a[$i][3]=$row[3];
                $a[$i][4]=$row[4];
                $i++;
           }
           return $a;
        break;
        case "quetion":
           $query=            "SELECT DISTINCT id, 'ask' AS part, 'quetion' as field, count('%$searchWord%') as cnt, '$searchWord' as searchWord FROM ask WHERE quetion LIKE  $like GROUP BY id";
           $query.=" UNION SELECT DISTINCT id, 'ask' AS part, 'answer' as field, count('%$searchWord%') as cnt, '$searchWord' as searchWord FROM ask WHERE answer LIKE  $like GROUP BY id";
           $result=mQuery($query);
           $i=0;
           while ($row=mysql_fetch_array($result))
           {
                $a[$i][0]=$row[0];
                $a[$i][1]=$row[1];
                $a[$i][2]=$row[2];
                $a[$i][3]=$row[3];
                $a[$i][4]=$row[4];
                $i++;
           }
           return $a;
        break;
        case "regards":
           $query=            "SELECT DISTINCT id, 'regards' AS part, 'regard' as field, count('%$searchWord%') as cnt, '$searchWord' as searchWord FROM regards WHERE regard LIKE  $like GROUP BY id";
           $result=mQuery($query);
           $i=0;
           while ($row=mysql_fetch_array($result))
           {
                $a[$i][0]=$row[0];
                $a[$i][1]=$row[1];
                $a[$i][2]=$row[2];
                $a[$i][3]=$row[3];
                $a[$i][4]=$row[4];
                $i++;
           }
           return $a;
        break;
        case "goods":
           $query=            "SELECT DISTINCT id, 'em_goods' AS part, 'name' as field, count('%$searchWord%') as cnt, '$searchWord' as searchWord FROM em_goods WHERE name LIKE  $like GROUP BY id";
           $query.=  " UNION SELECT DISTINCT id, 'em_goods' AS part, 'description' as field, count('%$searchWord%') as cnt, '$searchWord' as searchWord FROM em_goods WHERE description LIKE  $like GROUP BY id";
           $result=mQuery($query);
           $i=0;
           while ($row=mysql_fetch_array($result))
           {
                $a[$i][0]=$row[0];
                $a[$i][1]=$row[1];
                $a[$i][2]=$row[2];
                $a[$i][3]=$row[3];
                $a[$i][4]=$row[4];
                $i++;
           }
           return $a;
        break;        
        default:
            $a= array_merge ( partSearch('info',$searchWord), partSearch('news',$searchWord), partSearch('quetion',$searchWord), partSearch('regards',$searchWord), partSearch('goods',$searchWord));
        break;
    }
    return $a;
 }


 #функция выделяющая подстроку в строке
 function selectSubStr($subString,$string)
 {
    $LStr=StrToLower($string);
    $LSubStr=StrToLower($subString);
    $AfterSubString=strstr($LStr,$LSubStr) ;
    #вот отсюдава начинается искомая подстрока
   // echo "<br>==$LSubStr====$AfterSubString==<br>";
    $NumFirstSubStr=strPos($LStr,$AfterSubString);
    #вот здесь она заканчивается
    $NumEndSubStr=strPos($AfterSubString,' ')+$NumFirstSubStr;
    if (($NumFirstSubStr=="") && ($NumEndSubStr==""))
        return $string;
    if($NumEndSubStr==$NumFirstSubStr)
    {
      $NumEndSubStr=StrLen($string);
    }
    //echo "<br>sub= '$subString' first=$NumFirstSubStr  end=$NumEndSubStr<br>";
    //$string=substr($string,0,$NumFirstSubStr)."<b>".substr($string,$NumFirstSubStr,$NumEndSubStr-$NumFirstSubStr)."</b>".substr($string,$NumEndSubStr );
    $string=substr($string,0,$NumFirstSubStr)."<b>".substr($string,$NumFirstSubStr,$NumEndSubStr-$NumFirstSubStr)."</b>".selectSubStr($subString,substr($string,$NumEndSubStr ));
    //echo "<br>first=$NumFirstSubStr  end=$NumEndSubStr $AfterSubString<br>";
    return $string;
 }
#Функция сокращающая страницу в которой найдена поисковая комбинация
function ShortString ($searchArray,$string,$ClauseCount)
{
   $result=Array();
   $i=0;
   $string=explode(".",$string);
   //$GetStringForm=0;
   #бегу по предложениям страницы
   foreach($string as $s)
   {
       #привожу к одному регистру
       $Ls=StrToLower($s);
       foreach($searchArray as $a)
       {
          #привожу к одному регистру
          $La=StrToLower($a);
          if (strPos($Ls,$La)!="")
          {
            $result[$i]=$s;
            //$GetStringForm=$i;
            $i++;
            break;
          }
       }
       #Если набрали достаточное количество предложений товыходим
       if ($i==$ClauseCount)
        break;
   }
   #если на стьранице ничего не найдено, ведь надо все-равно что-то показать
   # в такм случае вывожу ClauseCount строк
   if (implode("",$result)=="")
   {
        for($i=0;$i<$ClauseCount;$i++)
        {
            if($string[$i]!='')
                $result[$i]=$string[$i];
        }
   }

   return $result;
}
#функуия поиска по сайту
 function search ($searchString)
 {
 global $ClauseCount,$GlobSearchButton,$smode;
 global $spage, $PrintSearchResultCount;
 print "<br>";
 if (($searchString=='Поиск') || ($searchString==''))
 {
    searchForm(40,"",$GlobSearchButton);
    print "<b>Задан пустой поисковый запрос. </b>";
    return;
 }
    searchForm(40,$searchString,$GlobSearchButton);
       #удаляю лишние пробелы
     while (strPos($searchString,"  ")==true)
        $searchString=str_replace("  "," ",$searchString);
     $searchString=trim($searchString);
     $searchArray=explode(" ",$searchString);
     //print "$searchString <br>";
     $result = array();
     $res = array();
     foreach ($searchArray as $a)
     {
       $res= partSearch($smode,$a);
       $result=array_merge($result,$res);

      // print "-$a<br>";
     }
     $n=count($result);
     if ($n==0)
     {
        print "<B>Искомая комбинация слов нигде не встречается.</B>";
     }



#УДАЛЯЮ ДУБЛИРУЮЩИЕСЯ ЗАПИСИ
    for ($i=0; $i<$n;$i++)
    {
    if (@($result[$i][0].$result[$i][1])=='')   continue;
        for ($j=0; $j<$n;$j++)
        {
            if ($i==$j) continue;
            if ((@($result[$i][0].$result[$i][1]))==(@($result[$j][0].$result[$j][1])))
            {
                $result[$i][3]+=$result[$j][3];
                unset($result[$j]);  #образуется пустая строка
            }
        }
    }
    #убираю пустрые строки
    $res=array();
    $i=0;
     foreach ($result as $r)
     {
        $res[$i]=$r;
        $i++;
     }
     $result=$res;

#проверяю регулярными выражениями
//    $r=array();
    //$n=count($result);
   //for ($i=0; $i<$n;$i++)
    //{
//           $r=$result[$i];
//           print "<br>-$r[0],$r[1], $r[2], $r[3], $r[4]<br>";
//           $resultq=mQuery("SELECt $r[2] FROM $r[1] WHERE id=$r[0]");
//           $row=mysql_fetch_array($resultq);
//           $pattern="^[[:punct:]]+|[[:space:]]+$r[4]+[[:punct:]]+|[[:space:]]";
//           $pattern="[[:space:]]+$r[4]|[[:space:]]";
//           echo "$pattern<br>";
//           if (!eregi($pattern,$row[0]))
//           {
//              unset($result[$i]);
//            print "<br><b>Пришлось удалить $i элемент</b><br>";
//           }
//    }
    #убираю пустрые строки
    $res=array();
    $i=0;
     foreach ($result as $r)
     {
        $res[$i]=$r;
        $i++;
     }
     $result=$res;
    #сортировка массива по количеству совпадений
    $i=0;
    $buf=Array();
    while ($i!=count($result))
    //for($i=0; $i<count($result);$i++)
    {
       if ($result[$i][3]<$result[$i+1][3])
       {
            $buf=$result[$i];
            $result[$i]=$result[$i+1];
            $result[$i+1]=$buf;
            $i=0;
       }
       $i++;
    }


     #тут добвавлю постраничный вывод результата поиска
    #поэтому старые циклы прийдется закоментировать
    //определяю с кокого эл-та массива выводить
    $p=($spage-1)*$PrintSearchResultCount;
    if ($p<0) $p=0;
    //$p=2;
    print "<br><font color=\"#5897F8\">Всего найдено <b>".count($result)."</b> страниц.</font><br>";
    $r=array();
    $CntSteps=$p+$PrintSearchResultCount;
    if ($CntSteps>count($result))
       $CntSteps=count($result);
       $j=$p+1;
     for($i=$p; $i<$CntSteps; $i++)
     {
     $r=$result[$i];
        if ($r[1]=='') continue;
          #определяю какой SHOW мне нужен
          switch ($r[1])
          {
            case  "pages":
                $show="info";
                $parts="Основная информация";
                $title="Искать в основной информации";
                $href="stext=$searchString&show=search&smode=info";
                $field="descr";
                $secondField=", page";
            break;
            case  "news":
                $show="news";
                $parts="Новости";
                $title="Искать в новостях";
                $href="stext=$searchString&show=search&smode=news";
                $field="name";
                $secondField=", news";
            break;
            case  "regards":
                $show="regards";
                $parts="Отзывы";
                $title="Искать в книге отзывов и предложений";
                $href="stext=$searchString&show=search&smode=regards";
                $field=$r[2];
                $secondField="";
            break;
            case  "ask":
                $show="ask";
                $parts="Вопросы";
                $title="Искать в вопросах-ответах\"";
                $href="stext=$searchString&show=search&smode=quetion";
                $field=$r[2];
                $secondField="";
            break;
            case  "em_goods":
                $show="goods";
                $parts="Товары";
                $title="Искать в ноименованиях товаров\"";
                $href="stext=$searchString&show=search&smode=goods";
                $field='name';
                $secondField=", description";
            break;            
          }
          $resultq=mQuery("SELECT $field $secondField  FROM $r[1] WHERE id=$r[0]");
        $row=mysql_fetch_array($resultq);
        if ($row[1]!="")
            {
            $row[1]=implode(". ", ShortString ($searchArray,$row[1],$ClauseCount)).".";
            //$row[0]=implode(". ", ShortString ($searchArray,$row[0],$ClauseCount)).".";
            }
        else
            $row[0]=implode(". ", ShortString ($searchArray,$row[0],$ClauseCount)).".";
        foreach ($searchArray as $a)
        {
            $row[0]=selectSubStr($a,$row[0]);
            $row[1]=selectSubStr($a,$row[1]);
        }
        //echo"<br>---------------------------<br>";
        echo"<br>";

        if ($row[1]=="")
        print "$j ";
        $row[0] = strip_tags($row[0],"<td>");
        $row[0] = strip_tags($row[0],"</td>");
        $row[0] = strip_tags($row[0],"<tr>");
        $row[0] = strip_tags($row[0],"</tr>");
        $row[0] = strip_tags($row[0],"<table>");
        $row[0] = strip_tags($row[0],"</table>");
        print "<a href='?show=$show&id=$r[0]'>$row[0]</a>";
        //$row[1] = strip_tags($row[1],"<table border=\"2\"> <table> </table> <td> </td> <tr> </tr>");
        $row[1] = strip_tags($row[1],"<td>");
        $row[1] = strip_tags($row[1],"</td>");
        $row[1] = strip_tags($row[1],"<tr>");
        $row[1] = strip_tags($row[1],"</tr>");
        $row[1] = strip_tags($row[1],"<table>");
        $row[1] = strip_tags($row[1],"</table>");
        
        if ($row[1]!="")      
         print "<br>$j.<font size='2'>$row[1]</font>";
        print "<br><div align='RIGHT'><font align='RIHGT' size=2>Найдено в <b><a style=\"COLOR:BLUE\" href='?$href' title='$title'>$parts</a></b></font></div>";
      $j++;
     }
  #постраничный вывод результатов поиска
  $pcnt=ceil(count($result)/$PrintSearchResultCount);
  if ($p=0) $p=1;
  for($i=1; $i<=$pcnt;$i++)
  {
   if ($i!=$spage)
      print"<a href='?stext=$searchString&show=search&smode=$smode&spage=$i'>$i</a>&nbsp;&nbsp;";
   else
       print"$i&nbsp;&nbsp;";
  }

     ##############################

 }
 # Функция рисующая поисковый диалог
 function searchForm($size,$value,$SubmitValue)
 {
    global $DefaultSearch,$FastSearchButton;
    print "<form>";
    if ($SubmitValue==$FastSearchButton)
    {
        print "<input type='text' class=\"searcht1\" style=\"color:#5897F8;\" name='stext' id='idsearch' size='$size' value='$value' onfocus=\"if (this.value=='Поиск') this.value=''; this.style.color='black';\" onblur=\"if (this.value=='') this.value='Поиск'; this.style.color='#5897F8';\">";
        print "<input type='SUBMIT' class=\"searchb1\" value='$SubmitValue'>";
    }
    else
    {
        print "<input type='text' class=\"searcht2\" style=\"color:BLACK;\" name='stext' id='idsearch' size='$size' value='$value'>";
        print "<input type='SUBMIT' class=\"searchb2\" value='$SubmitValue'>";
    }

    print "<input type='hidden' name='show' value='search'>";
    print "</form>";
 }
function GetHost()
{
 $uri = $_SERVER['REQUEST_URI'];
 $server= $_SERVER['SERVER_NAME'];
 $uri = subStr($uri,1);
 $uri = subStr($uri,0,strPos($uri,"/"));
 if (_is_inet==1){
    return "http://$server/";
 }
 else
    return "http://$server/$uri/";
} 
function addLog($s)
{
    $logFile = 'CMS_LOG.log';
    $uri = $_SERVER['REQUEST_URI']; 
    $uri = subStr($uri,1);
    $uri =$_SERVER['DOCUMENT_ROOT']."/". subStr($uri,0,strPos($uri,"/"))."/$logFile";
    $_SESSION['sysmsg'] .= "$s<br>";
    $s = "[".date('j.m.Y G:i:s')."]  $s";
    $fp = fopen($uri, "a");
    fwrite($fp, "$s\n");
    fclose($fp);    
}
function GetGoodsList($cnt)
{
    $result = Array();
    $i = 0;
    $res = mQuery("SELECT id, name FROM em_goods LIMIT 0,$cnt");
    while ($row = mysql_fetch_row($res))
    {
        $result[$i] = $row;
        $i++;
    }
    return $result;
}
function PrintGoodsList($list)
{
    $i = 0;
    foreach($list as $l)
    {
        print "<li class=\"parent\">";
        print "<span class=\"bullet\">&nbsp;</span><a href=\"?show=goods&id={$l[0]}\">{$l[1]}</a>";
        print "</li>";
        $i++;
    }       
    if ($i==0)
      print "<b>Список товаров пуст</b>";  
}
function checkOrderForm()
{
    $firstname = strip_Tags($_POST['firstname']);
    $lastname = strip_Tags($_POST['lastname']);
    $tel = strip_Tags($_POST['tel']);
    $email = strip_Tags($_POST['email']);
    $adres = strip_Tags($_POST['adres']);
    $descr = strip_Tags($_POST['descr']);
    $rcontrdig = $_POST['rcontrdig'];
    $issave = $_POST['issave'];

    $ErrMes = '';
    if ($firstname=='')
        $ErrMes .= 'Имя не указано.<br>';
    if ($lastname=='')
        $ErrMes .= 'Фамилия не указана.<br>';
    if ($tel=='')
        $ErrMes .= 'Телефон не указан.<br>';
    if ($email=='')
        $ErrMes .= 'Email  не указан.<br>';
    if (!preg_match("|^([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|is", strtolower($email)))
    {
            $ErrMes .= 'Указан некорректный email.<br>';
    }

    if ($adres=='')
        $ErrMes .= 'Адрес не указана.<br>';  
    if ($ErrMes=='')   
    {
        if ($_SESSION['contrdig']=='')
            $ErrMes = 'Контрольное число не указано';
        else        
        if ($_SESSION['contrdig']!=$rcontrdig)
            $ErrMes = 'Неверное контрольное число';
    }
    return $ErrMes;
}
function getMetaTags($show,$id)
{                                           
    switch ($show)
    {
   case "news":
       $dir="news";
   break;
   case "info":
       $dir="pages";
   break; 
   case "goods":
       $dir="em_goods";
   break;      
   default:
      return "";
   break;
   }
   $res = mQuery("SELECT metadescription, metakeywords FROM $dir WHERE id = $id");
   $row = mysql_fetch_row($res);
   $metadescr = stripslashes($row[0]);
   $metawords = stripslashes($row[1]);
   $result  = "<META NAME='description' CONTENT='$metadescr'>\n";   
   $result .= "<META NAME='keywords' CONTENT='$metawords'>\n";
   return $result;   
}
function getLastModified($show,$id)
{  
    switch($show)
    {
        case "news":
            $res = mQuery("select ndate FROM news WHERE id = '$id'");    
            if (!($row=mysql_fetch_row($res)))
                return '';
            $last_modified_time = $row[0];
        break;
        case "allnews":
            $res = mQuery("select max(ndate) FROM news WHERE id = '$id'");    
            if (!($row=mysql_fetch_row($res)))
                return '';
            $last_modified_time = $row[0];
        break; 
        case "info":
            $res = mQuery("select pdate FROM pages WHERE id = '$id'");    
            if (!($row=mysql_fetch_row($res)))
                return '';
            $last_modified_time = $row[0];
        break; 
        case "goods":
            $res = mQuery("select updatedate FROM em_goods WHERE id = '$id'");    
            if (!($row=mysql_fetch_row($res)))
                return '';
            $last_modified_time = $row[0];
        break;      
        case "catalog":
            $res = mQuery("select max(updatedate) FROM em_goods WHERE id = '$id'");    
            if (!($row=mysql_fetch_row($res)))
                return '';
            $last_modified_time = $row[0];
        break;        
        default:
            return "";
   break;
   
    }
header("Last-Modified: ".gmdate("D, d M Y H:i:s", $last_modified_time)." GMT");
  // echo("Last-Modified: ".gmdate("D, d M Y H:i:s", $last_modified_time)." GMT");    
}
function getTitle($show,$id)
{
    switch($show)
    {
        case "news":
            $res = mQuery("select name FROM news WHERE id = '$id'");    
            if (!($row=mysql_fetch_row($res)))
                return '';
            return  $row[0];
        break;
        case "allnews":
            return  'Новости';
        break; 
        case "info":
            $res = mQuery("select name FROM pages WHERE id = '$id'");    
            if (!($row=mysql_fetch_row($res)))
                return '';
            return  $row[0];
        break; 
        case "goods":
            $res = mQuery("select name FROM em_goods WHERE id = '$id'");    
            if (!($row=mysql_fetch_row($res)))
                return '';
            return  $row[0];
        break;      
        case "catalog":
            return  'Каталог';
        break;        
        case "allregards":
            return  'Отзывы';
        break;         
        case "ask":
        case "allask":
            return  'Вопросы';
        break;  
        case "search":
            return  'Поиск';
        break;               
        default:
            return "";
   break;
   
    }
}
  function getUserSideJSConst(){
    $res = "<script>";
    $res .= "var host='".GetHost()."';";
    $res .= "var modalAlertPlace='"._MODAL_ALERT_PLC."';";
    $res .= "var modalLoginPlace='"._MODAL_LOGIN_PLC."';";
    $res .= "var modalAuthPlace='"._MODAL_AUTH_PLC."';";
    $res .= "</script>";
    return $res;
  }
  function getModalAlertPlace(){
    //return  "<div  id='"._MODAL_ALERT_PLC."'></div><div  id='"._MODAL_LOGIN_PLC."'></div>";
    return  "<div style=\"visibility:hidden\" id='"._MODAL_AUTH_PLC."'></div>
            <div style=\"visibility:hidden\" id='"._MODAL_ALERT_PLC."'></div>
            <div style=\"visibility:hidden\" id='"._MODAL_LOGIN_PLC."'></div>";
  }
?>