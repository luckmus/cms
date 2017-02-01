<?php
# Длина отзыва выводимая в основной таблице
$RegardLen=100;
# Длина вопроса выводимая в основной таблице
$QuetionLen=50;
# Длина ответа выводимая в основной таблице
$AnswerLen=50;
#количество файлов на странице
$CountFilesOnPage = 5;
define ('_upper_level','../');

#путь к папке modules
define('_MODULES_PATH','../modules');
define('_MODULES_EM_PATH',_MODULES_PATH.'/em/');
define('_MODULES_MSG_PATH',_MODULES_PATH.'/messages/');

define('_IS_ARCH','_is_arch');

#основной контейнер параметров
define("_MAIN_PARAM_CONT",'main_param_cont');
define("_MAIN_CATEG_CONT",'main_categ_cont');
define("_ALL_CATEG_CONT",'allcat-cont');
define("_MAIN_GOODS_CONT",'main_goods_cont');
define("_MAIN_PROMO_CONT",'main_promo_cont');
define("_ALL_GOODS_CONT",'allgoods-cont');
define("_ALL_PROMO_CONT",'allpromo-cont');
define("_GOODS_PARAM_CONT",'goods_param_cont');
define("_GOODS_PARAM_EDT_MSG",'goods-param-edt-msg');
define("_GOODS_EDT_MSG",'goods-edt-msg');
define("_PROMO_EDT_MSG",'promo-edt-msg');
define("_ADM_FRONTEND",'adm/FRONTEND/');
define("_ADM_BACKEND",'adm/BACKEND/');
define ('_DIALOGS_PATH','modules/FRONTEND/dlgMessages/');

?>