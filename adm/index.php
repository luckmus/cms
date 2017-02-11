<?php
@session_start();
include "../libs/db.php";
include "../config.php";   
include "../libs/helpers.php";
include "../libs/commonfunctions.php";
include "../libs/vars.php"; 
include "libs/initvars.php";
include "libs/helpers.php";
include "libs/vars.php";
$dbh=DBConnect($DBHost, $DBUser, $DBPass, $DBName);
//mQuery('SET character_set_database = cp1251');
mQuery("SET NAMES 'cp1251'", $dbh);  
#выполняю операции с данными, и тлько потом отображаю
include "head.php";
?>
<html>
<head>
  <title>Панель администратора.</title>                                     
  <meta http-equiv="content-type" content="text/html; charset=windows-1251">
  <meta http-equiv="Cache-Control" content="no-cache">
  <link rel="stylesheet" href="css/style.css">
<!--jQuery-->
    <link rel="stylesheet" href="../themes/base/jquery.ui.all.css">
    <link rel="stylesheet" href="../css/verticaltab.css">
    <script src="../js/jquery-1.6.2.js"></script>
    <script src="../js/ui/jquery.ui.core.js"></script>
    <script src="../js/ui/jquery.ui.widget.js"></script>
    <script src="../js/ui/jquery.ui.tabs.js"></script>
    
    <script src="../js/external/jquery.bgiframe-2.1.2.js"></script>
    <script src="../js/ui/jquery.ui.mouse.js"></script>
    <script src="../js/ui/jquery.ui.button.js"></script>
    <script src="../js/ui/jquery.ui.draggable.js"></script>
    <script src="../js/ui/jquery.ui.position.js"></script>
    <script src="../js/ui/jquery.ui.resizable.js"></script>
    <script src="../js/ui/jquery.ui.datepicker.js"></script>
    
    <script src="../js/ui/jquery.ui.dialog.js"></script>
    <script src="../js/ui/jquery.effects.core.js"></script>
    <script src="../js/common.js"></script>
    <script src="../js/boxberry.js"></script>
    <script src="js/message.js"></script>
<!--
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
-->     
    <style>
        body { font-size: 62.5%; }
        label, input { display:block; }
        input.text { margin-bottom:12px; width:95%; padding: .4em; }
        fieldset { padding:0; border:0; margin-top:25px; }
        h1 { font-size: 1.2em; margin: .6em 0; }
        div#users-contain { width: 350px; margin: 20px 0; }
        div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
        div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
        .ui-dialog .ui-state-error { padding: .3em; }
        .validateTips { border: 1px solid transparent; padding: 0.3em; }
    </style>




<!-- TinyMCE -->
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<!--<script type="text/javascript" src="../tiny_mce/tiny_mce.js"></script>-->
<script type="text/javascript">
    tinyMCE.init({
        // General option
        mode : "exact",
        //mode : "textareas",
        elements: "page, news, answer, goods",
        theme : "advanced",
        plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

        // Theme option
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        // Example content CSS (should be your site CSS)
        content_css : "css/content.css",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "lists/template_list.js",
        external_link_list_url : "lists/link_list.js",
        external_image_list_url : "lists/image_list.js",
        media_external_list_url : "lists/media_list.js",

        // Style formats
        style_formats : [
            {title : 'Bold text', inline : 'b'},
            {title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
            {title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
            {title : 'Example 1', inline : 'span', classes : 'example1'},
            {title : 'Example 2', inline : 'span', classes : 'example2'},
            {title : 'Table styles'},
            {title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
        ],

        // Replace values for the template plugin
        template_replace_values : {
            username : "Some User",
            staffid : "991234"
        } 
    });
</script>
<!-- /TinyMCE -->

</head>


<body>
<?php
echo getJSConst();                                  
echo getModalAlertPlace();                                  
print "<table border=1 align='CENTER'>"; #таблица Т1
print " <tr>";
print "  <td>";
print "<div align='center' style='font.size:24;font.style:bold;'><a href='?'>Панель администратора сайта.</a></div>";
print "  </td>";
print " </tr>";
print " <tr>";
print "  <td>";
print "   <table border=0 width=100%>";#таблица Т2
//print "   <table border=1 style=\"width=100%\">";#таблица Т2
print "    <tr>";
print"      <td width='500' valign=\"TOP\">";
# ссылки управления админкой
print "<table border = 0>";
print "<tr><td><a class=\"hpages\" href=\"?show=parts\">Разделы</a></td></tr>";
print "<tr><td><a class=\"hpages\" href=\"?show=info\">Страницы</a></td></tr>";
print "<tr><td><a class=\"hpages\" href=\"?show=news\">Новости</a></td></tr>";
print "<tr><td><a class=\"hpages\" href=\"?show=ask\">Вопросы</a></td></tr>";
print "<tr><td><a class=\"hpages\" href=\"?show=regards\">Отзывы</a></td></tr>";
print "<tr><td><a class=\"hpages\" href=\"?show=upload\">Загрузка файлов</a></td></tr>";
print "<tr><td><a class=\"hpages\" href=\"?show=settings\">Настройки</a></td></tr>";  
print "<tr><td><b>Магазин</b></td></tr>";
print "<tr><td><a class=\"hpages\" href=\"?show=category\">Категории</a></td></tr>";
print "<tr><td><a class=\"hpages\" href=\"?show=goods\">Товары</a></td></tr>";
print "<tr><td><a class=\"hpages\" href=\"?show=archgoods\">Архив</a></td></tr>";
print "<tr><td><a class=\"hpages\" href=\"?show=params\">Параметры</a></td></tr>";
print "<tr><td><a class=\"hpages\" href=\"?show=orders\">Заказы</a></td></tr>";
print "<tr><td><a class=\"hpages\" href=\"?show=promo\">Промо-коды</a></td></tr>";
print "</table>";

print"      </td>";
print"      <td style=\"width:100000\" valign=\"TOP\">";
print"<div class='adm_right'>";
#собтвенно редакция сайта
ShowAdmPart($show);
print"</div>";
print"      </td>";
print "    </tr>";
print "</table>";#таблица Т2
print "  </td>";
print " </tr>";
print "</table>";#таблица Т1
?>
</body>
</html>
