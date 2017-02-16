<?php
    header("Content-type: text/html; charset=windows-1251");       
    include "../../../adm/libs/helpers.php"; 
    include "../../../libs/commonfunctions.php"; 
    include "../../../libs/vars.php"; 
    include "../../messages/message.php"; 
    $url = $_SERVER['DOCUMENT_ROOT']."/".getUri()._UploadDir;
    $goodsId = $_GET['goods_id'];
    $isXML = $_GET['isXML']; 
     $randId = $_GET['id'];
    $imgCont = "goods-gal-img-$goodsId-$randId";
      $AllFilesList = LoadFromDir($url);
      //var_dump($AllFilesList);
      $imgId = "img-$randId";
      $content = "";
      $content.= "<select name='imagefile' id='$imgCont' style='width:200px' onChange=\"$('#$imgId').attr('src',  '../'+this.value);  console.log(this.value);\">";
      $first = "../".$AllFilesList[0][2]; 
      foreach($AllFilesList as $file){     
        $content.= "<option value='{$file[2]}' $imgSelected >{$file[1]}";
      }
      $content.= "</select><br>";
      
      $content.= "<img id='$imgId' src='$first' style=\"width: 110px;height: 110px;\"/><br/>";
      $descr = "gf-descr-$id";
      $content.= "<label for='$descr'>Описание</label><textarea id='$descr' cols=40 rows=10></textarea>";
      $msg = new Message($id,"Фото для галлереи",$content,"alert",'1',"");
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