<?php
    class mainViewer{
        static public $show;
        static public $id;
        
        function mainViewer(){
            
        }
        
        static public function getMainMenu(){
            include "modules/FRONTEND/skin/{$GLOBALS[SKIN_VAR]}/main_menu.php";           

        }
        static public function getTitle(){
            mainViewer::initVars();
            $title = _title.' ';
            switch(mainViewer::$show){
                case _CATEGORY:
                    Includer::initCategoryFromRoot();
                    $cat = new Category(mainViewer::$id);
                    $cat->loadProperties();
                    $title .= $cat->name;
                break;
                case _GOODSONE:
                    Includer::initGoodsFromRoot();
                    $goodsOne = new Goods(mainViewer::$id);
                    $goodsOne->Load();
                    $title .= $goodsOne->name;                
                break;
                case _CART:
                       Includer::initGoodsFromRoot(); 
                       $title .= "Корзина";
                break;
                default:
                    $title .= getTitle(mainViewer::$show,mainViewer::$id);
                break;
            }
            return $title;
        }
        static public function showCateg(){
            mainViewer::initVars(); 
            switch(mainViewer::$show){
                case _CATEGORY:                    
                    $viewCategId = mainViewer::$id;
                break;
                default:
                    $viewCategId = null;
                break;
            }
            if ((mainViewer::$show=="") ||(mainViewer::$show==_CATEGORY)){
            include "modules/shop/categories_skin.php";
            }
            
        }
        static public function showData(){
             mainViewer::initVars();
             require_once "modules/em/init_module.php";
             require_once "modules/FRONTEND/skin/common_skin/common_goodsone.php";
             echo "<div style='margin: 10px 50px 20px 50px';>";
             switch(mainViewer::$show){
                case "":
                    $viewCategId = null;                    
                     //mainViewer::showCateg();                    
                    include "modules/shop/catalog_skin.php";
                break;
                case _CATEGORY:
                    $viewCategId = mainViewer::$id;
                     //mainViewer::showCateg();
                    include "modules/shop/catalog_skin.php";
                break;                
                case _GOODSONE:
                    $common_goodsone = new Common_goodsone(mainViewer::$id);
                    echo $common_goodsone->getView();
                break;                
                case _CABINET:
                    require_once "modules/em/usercommunication.php";
                    require_once "modules/em/em_accounts.php";
                    require_once "modules/FRONTEND/skin/common_skin/cabinet_viewer.php";
                    echo CabinetViewer::getView($_SESSION[_LOGIN_ID]);
                break;
                case _CART:
                    require_once "modules/em/em_cart.php";
                    include "modules/shop/cart_skin.php";
                break;
                
                default:
                    print "<br>";
                    print "<br>";
                    print "<br>";
                    print "<br>";
                    ShowData(mainViewer::$show,mainViewer::$id);
                break;                
                
             }
             echo "</div>";
        }
    
        static private function initVars(){
            mainViewer::$show = $_GET['show'];
            mainViewer::$id = $_GET['id'];
        }
    }
?>