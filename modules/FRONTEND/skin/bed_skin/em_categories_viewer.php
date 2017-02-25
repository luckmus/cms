<?php
    class CategoriesViewer{
        private $categories;                                            //Список всех категорий
        public $activeCat;
        
        function CategoriesViewer($categories){
            $this->categories = $categories;    
        }
        
        public function getView(){
            $res = '<div id="linemarks"><div id="linemarks_cont">';
            $res .= '<ul class="cfx">';
            $href = GetHost(); 
            $class = '';
            if ($this->activeCat==null){
                $class = ' class="active"'; 
            }
            $res .= '<li'.$class.'><a href='.$href.'>Все</li>';

            $allCat = $this->categories->getCategoryes();
            for ($i=0; $i<count($allCat); $i++){
                $categ = $allCat[$i];
                $categ->Load();     
                $href = GetHost()."?show="._CATEGORY."&id={$categ->id}";
                $class = '';
                if ($this->activeCat==$categ->id){
                    $class = ' class="active"'; 
                }                
                 $res .= "<li$class><a href='$href'>{$categ->name}</a></li>";
            }
            $res .= '</ul></div></div>';
            return $res;
        }
        
        public static function getViewStatic($categories,$viewCategId){
            $Categs = new CategoriesViewer($categories);
            $Categs->activeCat = $viewCategId;
            return '<div id="sc1">'.$Categs->getView()."<div>";
        }
             
    }

?>