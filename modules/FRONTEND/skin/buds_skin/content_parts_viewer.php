<?php
    class PartsViewer{
        private $patrs;                     //массив описывающий все категории страниц, объектоа Part
        
        function PartsViewer($patrs){
            $this->patrs = $patrs;
        }
        
        
        public function getPartsView(){
            $res = '';
            $host = GetHost();
            $i=0;
            foreach($this->patrs as $part){
                if ($i==0){
                    $padding = 0;
                }
                else{
                    $padding = 50;
                }
                $width = 163;
                switch($i){
                    case 0:
                        $width = 163;
                    break;
                    case 1:
                        $width = 117;
                    break;
                    case 2:
                        $width = 217;
                    break;
                    case 3:
                        $width = 155;
                    break;
                    
                }
                $res .= "<dl style=\"width:{$width}px; padding-left:{$padding}px;\"> "; 
                $res .= "<dt>{$part->name}</dt> ";
                $res .= "<dd><ul>";
                $pages =   $part->loadPages();
                addLog(' pages cnt = '.count($pages));
                foreach($pages as $page){
                    $res .= "<li><a href='$host?show=info&id={$page->id}'>{$page->name}</a></li>\n";
                }                                                                                
                $res .= "</ul></dd></dl>\n";
                $res .= '<img src="templ_files/buds/footer-column-line.png" style="float: left;" height="77px" width="1px">';
                $i++;
            }
            addLog($res);
            return $res;
        }
        /**
        * $patrs список всех категорий
        * @desc 
        */
        static public function getViewer($patrs){
            $viewer = new PartsViewer($patrs);
            return $viewer->getPartsView();
        }
    
    
    }

?>