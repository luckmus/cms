<?php
    class Includer{
        public static function initAccounts(){
            require_once "../../em/usercommunication.php";
            require_once "../../em/em_accounts.php";
        }
        public static function initOrder(){
            Includer::initAccounts();
            require_once "../../em/em_Order.php";
            require_once "../../em/em_cart.php";
        }
        
        public static function initCategoryFromRoot(){
            require_once "modules/em/em_category.php";
        }        
        public static function initGoodsFromRoot(){
            require_once "modules/em/em_goods.php";
        }
        
        public static function initCartFromRoot(){
            require_once "modules/em/em_cart.php";
        }
    }
?>