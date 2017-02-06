<?php
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); 
session_start();
include "libs/helpers.php";
include "libs/db.php";
include "config.php";
require_once "libs/vars.php";
$dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
include "libs/initvars.php";
include "libs/init_settings_var.php"; 
include "modules/FRONTEND/userSide/main_view.php";
mQuery("SET NAMES 'cp1251'", $dbh);
/*
echo isset($_COOKIE)."<br>";
foreach($_COOKIE as $cook){
    echo "$cook<br>";
}
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<title><?php echo mainViewer::getTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=windows-1251">
    <meta name="keywords" content="магазин постельного белья">
    <meta name="description" content="магазин постельного белья">        
	<script type="text/javascript" src="add_files/jquery_003.js"></script>
    <script type="text/javascript" src="add_files/jquery-ui.js"></script>
    <script type="text/javascript" src="add_files/jquery_002.js"></script>
    <script type="text/javascript" src="add_files/swfupload_002.js"></script>
    <link href="add_files/default.css" rel="stylesheet" media="all">
    <script type="text/javascript" src="add_files/handlers.js"></script>
    <script type="text/javascript" src="add_files/swfupload_004.js"></script>
    <script type="text/javascript" src="add_files/swfupload_005.js"></script>
    <script type="text/javascript" src="add_files/swfupload_003.js"></script>
    <script type="text/javascript" src="add_files/swfupload.js"></script>
    <script type="text/javascript" src="add_files/scripts.js"></script>
    <link href="add_files/style.css" rel="stylesheet" media="all">
    <link href="add_files/jquery.css" rel="stylesheet" media="all">
     <link rel="icon" type="image/ico" href="favicon.ico"/>
     <link href="css/cart.css" rel="stylesheet" media="all">
     <!--<link rel="icon" type="image/jpg" href="ico.jpg" />-->
     
    <link rel="stylesheet" href="themes/base/jquery.ui.all.css">
    <script src="js/jquery-1.6.2.js"></script>
    <script src="js/jquery-ui-1.8.16.custom.min.js"></script>
    
    <script src="js/ui/jquery.ui.core.js"></script>
    <script src="js/ui/jquery.ui.widget.js"></script>
    <script src="js/ui/jquery.ui.tabs.js"></script>    
    <script src="js/ui/jquery.ui.accordion.js"></script>    
    <script src="js/external/jquery.bgiframe-2.1.2.js"></script>
    <script src="js/ui/jquery.ui.mouse.js"></script>
    <script src="js/ui/jquery.ui.button.js"></script>
    <script src="js/ui/jquery.ui.draggable.js"></script>
    <script src="js/ui/jquery.ui.position.js"></script>
    <script src="js/ui/jquery.ui.resizable.js"></script>

    <script src="js/ui/jquery.ui.dialog.js"></script>
    <script src="js/ui/jquery.effects.core.js"></script>
    <script src="js/common.js"></script>
    <script src="js/script.js"></script>
    <script src="js/cookie.js"></script>
    <script src="https://api-maps.yandex.ru/1.1/index.xml" type="text/javascript"></script>
    
    <script>
    <?php
      include "modules/FRONTEND/skin/bed_skin/skinscript.js";
    ?>
    </script>
    
<script type="text/javascript">

$(document).ready(function(){
    $(".cartopen").click(function() {

        var o = $(this).offset();
        this.blur();

        var $sp = $("#cart");
            $sp.fadeOut(1);
            $sp.css('display', 'block');


        $sp.fadeIn(200);
        //$('#cart-scroll-area').jScrollPane({scrollbarWidth: 4, reinitialiseOnImageLoad: true, animateStep: 70});
        $('#cart-scroll-area').jScrollPane({scrollbarWidth:4, animateStep: 70});
        //$('.scroll-pane').jScrollPane({showArrows:true,scrollbarWidth:19,dragMaxHeight:43});

      });

});
</script>    

     
    
<!--[if IE 7]>

<link rel="stylesheet" type="text/css" media="all" href="/skins/default/scripts/ie7.css" />

<![endif]-->
                                                               
<!--[if lte IE 6]>

<link rel="stylesheet" type="text/css" media="all" href="/skins/default/scripts/ie6.css" />

<![endif]-->
<script type="text/javascript">

	var $mopened;
	var $lopened;

</script>
<?php
    
    echo getUserSideJSConst();
?>
</head>
<body onload="showCartValue()">
<div id="logo"><a href="index.php"><img src="images/logo2.png" width="220px" height="220px" alt="Мастерская Папы Карло" title="Мастерская Папы Карло"/></a></div>
<div id="header">
	

	<div id="menutop" class="columns">
<?php
  echo mainViewer::getMainMenu();
?>
        
        <!--
        <div class="telephone" align="right">
            <div class="item">
                <p class="hphonecomment">Заказ товара, подробности доставки и&nbsp;наличия товара по&nbsp;телефону:</p>
                <div class="contact-tel">+7(812) 961-00-08<br> +7(921) 944-62-22</div>
            </div>
        </div>
        -->
      
</div>
<div id="sc1">
<div>
     <?php
       mainViewer::showCateg();
     ?> 
<div id="sc">

     <?php
     
       echo getModalAlertPlace();
//       mainViewer::showCateg();
       echo "<div style='margin: 100px 50px 20px 100px';>";
       print '<div style="width:70%; height:100%;" id="lcont1">'; 
       mainViewer::showData();
       print '</div>'; 
     ?> 
</div>

<script type="text/javascript" src="add_files/jquery.js"></script>
<script type="text/javascript" src="add_files/jScrollPane.js"></script>
    <script type="text/javascript" src="add_files/scripts_inner.js"></script>
<div id="datepick-div" style="display: none;"></div><div style="display: none;" id="tooltip"><h3></h3><div class="body"></div><div class="url"></div></div></body></html>