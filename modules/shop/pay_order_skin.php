<?php

    include "modules/FRONTEND/skin/common_skin/em_cl_order_viewer.php";
    
    print "<div>";
    $extPayed = false;
    switch(mainViewer::$show){
                case _PAY_INFO_SUCCESS:
                    print "Успешная оплата";
                    $extPayed = true;
                break;
                case _PAY_INFO_FAIL:
                    print "Неуспешная оплата";
                break;
                case _PAY_INFO_INPROGRESS:
                    print "Ожидание подтверждения оплаты";
                break;
                case _PAY_INFO_RETURN:
                    print "Отказ от оплаты"; 
                break;
                default:
                    print "Неизвестный статус оплаты, свяжитесь с нами по телефону указаному в разделе 'Контакты'";       
                break;
    }
    print "</div>";
    $view = new ClOrderView(addslashes($_GET['id']),$_GET['token']);
    $view->extPayed = $extPayed;  
    //print '<div style="width: 100%; height: 100%;" id="lcont"> ';
    print $view->getView();
    //print '</div>';

?>