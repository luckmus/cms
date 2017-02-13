<?php
switch ($show)
{
  case "parts":
    switch ($action)
    {
      case "up":
           $SystemMessage=up($id,$dir);
      break;
      case "down":
           $SystemMessage=down($id,$dir);
      break;
      case "addresult":
         EditParts($id);
      break;
      case "del":
         $SystemMessage=deleteRecord($id,$dir);
      break;
    }
  break;
  case "news":
    switch ($action)
    {
      case "addresult":
         $SystemMessage=EditNews($id);
      break;
      case "del":
         $SystemMessage=deleteRecord($id,$dir);
      break;
    }
  break;
  case "info":
    switch ($action)
    {
      case "up":
           $SystemMessage=up($id,$dir);
      break;
      case "down":
           $SystemMessage=down($id,$dir);
      break;
      case "addresult":
         $SystemMessage=EditPages($id);
      break;
      case "del":
         $SystemMessage=deleteRecord($id,$dir);
      break;
    }
  break;
  case "regards":
    switch ($action)
    {
      case "del":
         $SystemMessage=deleteRecord($id,$dir);
      break;
    }
  break;
  case "ask":
    switch ($action)
    {
      case "del":
         $SystemMessage=deleteRecord($id,$dir);
      break;
      case "addresult":
         $SystemMessage=EditAsk($id);
      break;
    }
  break;
  case "upload":
    switch ($action)
    {
      case "del":
         $SystemMessage=deleteFile($name);
         $redirect = "?show=upload&fpage=$fpage";
      break;
      case "addresult":
         $SystemMessage=EditFile($id);
         $redirect = "?show=upload&fpage=$fpage"; 
      break;
    }   
   break; 
  case "category":
    switch ($action)
    {
      case "up":
           $SystemMessage=up($id,$dir);
           $redirect = "?show=category";
      break;
      case "down":
           $SystemMessage=down($id,$dir);
           $redirect = "?show=category";
      break;
      case "addresult":
         EditÑategory($id);
         $redirect = "?show=category";
      break;
      case "del":
         $SystemMessage=deleteRecord($id,$dir);
         $redirect = "?show=category";
      break;
    }
    
  break;
  case "goods":
    switch ($action)
    {
      case "up":
           $SystemMessage=up($id,$dir);
           $redirect = "?show=goods";
      break;
      case "down":
           $SystemMessage=down($id,$dir);
           $redirect = "?show=goods";
      break;
      case "addresult":
         EditGoods($id);
         $redirect = "?show=goods";
      break;
      case "del":
         $SystemMessage=deleteRecord($id,$dir);
         $redirect = "?show=goods";
      break;
      case "copy":
         $SystemMessage=CopyGoods($id);
         $redirect = "?show=goods";
      break;      
    }
    
  break;
  case "orders":
  require_once "../modules/em/usercommunication.php";
  require_once "../modules/em/em_Order.php";
    switch ($action)
    {
      case "addresult":
         EditOrders($id);
         $redirect = "?show=orders";
      break;
      case "del":
         $SystemMessage=deleteRecord($id,$dir);
         $redirect = "?show=orders";
      break;     
    }
    
  break; 
    #Íàñòðîéêè
    case "settings":
      switch($action)
      {
         case "edit":
              EditSettings();
              $redirect="?show=settings";
         break;
      }      
    break;    
     #ïðîìîêîäû
    case "promo":
      switch($action)
      {
         case "edit":
              EditSettings();
              $redirect="?show=settings";
         break;
      }      
    break; 
  
  
}
if ($redirect!='')
    header("Location:$redirect");
?>

