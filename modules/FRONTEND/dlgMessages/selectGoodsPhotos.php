<?php
    header("Content-type: text/html; charset=windows-1251");       
    include "../../../adm/libs/helpers.php"; 
    include "../../../libs/commonfunctions.php"; 
    include "../../../libs/vars.php"; 
    include "../../../config.php"; 
    include "../../../libs/db.php";     
    include "../../messages/message.php"; 
    $url = $_SERVER['DOCUMENT_ROOT']."/".getUri()._UploadDir;
    $goodsId = $_GET['goods_id'];
    $photoId = $_GET['photo_id'];
    $photodescr = "";
    $path = "";
    $okFnc = "";
    if ($photoId!=null){
        $dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
        mQuery("SET NAMES 'cp1251'", $dbh);
        //загрузка информации о фото
            $query = "SELECT id, id_goods, link, ordinal, description from em_goods_photo where id={$photoId}"   ;
            $res = mQuery($query);
            if ($row=mysql_fetch_row($res)){
                $photodescr = $row[4];
                $path = $row[2];
            }
            $goodsId =  $photoId;
            $okFnc = "edtGalleryPhotoBE"; 
    }
    else{
         $okFnc = "addGalleryPhotoBE";
    }
    $isXML = $_GET['isXML']; 
     $randId = $_GET['id'];
     $id = $_GET['id'];
     $tabId = $_GET['tabId'];
     $msgId = $_GET['msgId'];
    $imgCont = "goods-gal-img-$goodsId-$randId";
      $AllFilesList = LoadFromDir($url);
      //var_dump($AllFilesList);
      $imgId = "img-$randId";
      $content = "";
      $content.= "<select name='imagefile' id='$imgCont' style='width:200px' onChange=\"$('#$imgId').attr('src',  '../'+this.value);  console.log(this.value);\">";
      $first = "../".$AllFilesList[0][2]; 
      foreach($AllFilesList as $file){     
          $selected = "";
          if ($path==$file[2]){
             $selected = "selected";     
             $first = "../".$file[2];
          }
        $content.= "<option value='{$file[2]}' $selected >{$file[1]}";
      }
      $content.= "</select><br>";
      
      $content.= "<img id='$imgId' src='$first' style=\"width: 110px;height: 110px;\"/><br/>";
      $descr = "gf-descr-$id";
      $content.= "<label for='$descr'>Описание</label><textarea id='$descr' cols=40 rows=10>$photodescr</textarea>";
      $msg = new Message($id,"Фото для галлереи",$content,$okFnc,"$goodsId, '$imgCont', '$descr', '$tabId', '$msgId'","");
      $msg->setRemoveMsgPlace(true);
      $msg->setHeight(400);
      //$msg->setWidth(400);
    #если xml, то сформирую ее
    if ($isXML == 1){
        $xml = $msg->getMessageXML();
        echo $xml;
    }
    else{
        if ($js!=1){
            echo $msg->getHTML();
        }
        else
        {
            echo $msg->getJS();
        }
    }
?>