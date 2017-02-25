<?php
    class CategoriesViewer{
        private $categories;                                            //Список всех категорий
        public $activeCat;
        
        function CategoriesViewer($categories){
            $this->categories = $categories;    
        }
        public function getView(){
            $res = "";
            $res .= "<ul>    <li>        <h2>АССОРТИМЕНТ</h2>        <ul>";

            $href = GetHost(); 
            $class = '';
            if ($this->activeCat==null){
                $class = ' style="color:#ff7000;"'; 
            }
            $res .= '<li><a href="'.$href.'" '.$class.'>Все</a></li>';

            $allCat = $this->categories->getCategoryes();
            for ($i=0; $i<count($allCat); $i++){
                $categ = $allCat[$i];
                $categ->Load();     
                $href = GetHost()."?show="._CATEGORY."&id={$categ->id}";
                $class = '';
                if ($this->activeCat==$categ->id){
                      $class = ' style="color:#ff7000;"'; 
                }                
                else{
                    $class = ''; 
                }
                 //$res .= "<li$class><a href='$href'>{$categ->name}</a></li>";
                 $res .= "<li><a href='".$href."' ".$class.">{$categ->name}</a></li>";
            }
            $res .= ' </ul></li> </ul>';
            return $res;
        }       
        public static function getViewStatic($categories,$viewCategId){
            $Categs = new CategoriesViewer($categories);            
            $Categs->activeCat = $viewCategId;            
            return $Categs->getView();
        }
        
        public static function getDescrStatic($viewCategId){
            $cat = new Category($viewCategId);    
            $cat->Load();
            return $cat->description;
        }
             
    }

?>