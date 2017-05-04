<?php
header("Content-Type:text/html; charset=windows-1251");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); 
session_start();
include "libs/helpers.php";
include "libs/db.php";
include "config.php";
require_once "libs/vars.php";
require_once "modules/messages/message.php";
$dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
include "libs/initvars.php";
include "libs/init_settings_var.php"; 
include "modules/FRONTEND/userSide/main_view.php";
mQuery("SET NAMES 'cp1251'", $dbh);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><style media="screen"></style>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">

<title><?php echo mainViewer::getTitle(); ?></title>

<link href="templ_files/buds/concept-style.css" rel="stylesheet" type="text/css">
<!--[if lte IE 9]>
<link href="/concept-style_ie.css?3" rel="stylesheet" type="text/css" media="all" />
<style type="text/css">
.sub-menu{background: #fff;position:absolute;top:44px;left:0;width:960px;z-index:1000;padding:32px 0 37px 0;display:none;}
</style>
<![endif]-->
    <link rel="stylesheet" href="themes/base/jquery.ui.all.css">
    <script src="js/jquery-1.7.js"></script>
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
    <script src="https://points.boxberry.de/js/boxberry.js"> </script>
    <script src="js/boxberry.js"></script>
    
    <script src="js/jquery.bxslider.min.js"></script>
    <link rel="stylesheet" href="css/jquery.bxslider.css">
    <link rel="stylesheet" href="css/gallery.css">
    <link rel="stylesheet" href="css/cart.css">
    <script>
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
<?php

    echo getUserSideJSConst();
?>

</head>
<body onload="showCartValue()">

<div class="overlay"></div>
<div class="lightbox_wrap">
	<div class="lightbox d_product-tall">
        </div>
</div>


<div id="layout">       
    <div id="top-bar">
		<div style="width:277px;float:left;">
			<img src="templ_files/buds/tel.jpg" alt="Р?РЅС‚РµСЂРЅРµС‚ - РјР°РіР°Р·РёРЅ">
		</div>                
 

                <div id="c-i">

<div class="user-menu">
            <!--<a href="#"  onclick="showAuthorisationFromLogin('<?php  $s=rand(10000,99999); Message::processMsgId($s); ?>.',modalAuthPlace);">Регистрация</a> | <a href="#" onclick="showLogin(modalLoginPlace);">Авторизация</a>-->
            <?php
              mainViewer::getLoginDlg();
            ?>
            
    </div>
</div>

       
	</div>

	<div id="header">
    	<div id="logo">
            <a href="https://wood-burg.ru">
                <img src="templ_files/buds/logo.jpg" alt="Hi-techBox.ru/">
            </a>
        </div>
<!--
        <div id="ru_nav">
                <ul>
                        <li><a href="http://www.conceptclub.ru/ru/lookbook" class="nav-2">LOOK-BOOK</a></li>
                        <li><a href="http://www.conceptclub.ru/ru/news" class="nav-3">111111111111</a></li>
                        <li><a href="http://www.conceptclub.ru/ru/stores" class="nav-4">2222222222222</a></li>
                        <li><a href="http://www.conceptclub.ru/ru/community/index" class="nav-5">33333333333</a></li>
                </ul>
        </div>
        -->
         <div id="ru_nav">
                 <div id="search">
            <?php
            
            searchForm(50,$DefaultSearch,$FastSearchButton);
            ?>
        </div>
          </div>

    </div>

<div class="promo">
        <a href="?show=info&id=21">
        <img src="templ_files/buds/ru-promo.jpg" alt="">
    </a>
    <span id="change_catalog_baner"></span>
</div>
<div id="content" class="right_content">
    <div class="catalog">
        <div class="catalog_filter">
            <div class="left">
                <ul>
                 <li><a class="current" href="?show=allnews">Новости</a></li>
                 <li><a href="?show=allask">Вопросы</a></li>
                 <li><a href="?show=allregards">Отзывы</a></li>
               </ul>
           </div>

         </div>
         <ul class="product_list product_list-tall">
<?php
  echo getModalAlertPlace();
?>         
      <?php
       //echo getModalAlertPlace();
//       mainViewer::showCateg();
       mainViewer::showData();
     ?>
        </ul>
     </div>
     </div>
                                                                        
          
<div id="sidebar" class="left_sidebar">
     <?php     
       mainViewer::showCateg();
       echo '<fieldset><legend>Корзина</legend><div class="cart-link"><a href="?show=cart">Товаров в корзине: <span id="cart_value">0</span></a></div></fieldset>';        
     ?>                   
     
</div>

    

      <?php
      if ((mainViewer::$show == _CATEGORY) && (mainViewer::$id!='')){
       //echo getModalAlertPlace();
//       mainViewer::showCateg();
        print '<div class="page_info"><div oncopy="return false" oncontextmenu="return false" onselectstart="return false"><h1 style="font-size: 12px;">Описание</h1>';
       mainViewer::showCategoryDescription();
       print '</div></div>';
      }
     ?>

       

    <div id="bottom">		
		<div class="bottom-right">
        <div id="footer_links">

<?php
     mainViewer::getParts();
?>

</div>
            <div id="footer">
                <div class="copyright">
                    <?php echo mainViewer::getTitle(); ?>
                </div>

            </div>                  

		</div>
	</div>
</div>
</body></html>