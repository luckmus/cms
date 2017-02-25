<?php
    class Part{
        private $id;
        public $name;
        private $pages;  //список страниц, объектоа Page
        
        function Part($id){
            $query = "SELECT id, name FROM parts WHERE id = $id";
            $res = mQuery($query);
            if ($row = mysql_fetch_row($res)){
                $this->id = $row[0];
                $this->name = $row[1];
            }    
        }
        
        function loadPages(){
            if ($this->pages != null){
                return $this->pages;
            }
            $query = "SELECT id, name FROM pages WHERE pid={$this->id}";
            addLog($query);
            $res = mQuery($query);
            $this->pages = Array();
            while ($row = mysql_fetch_row($res)){
                $page = new Page();
                $page->id = $row[0];
                $page->name = $row[1];
                $this->pages[count($this->pages)] = $page;
                addLog(count($this->pages));
            }
            return $this->pages;
        }
    }
    
    class Parts{
        private $prts;
        
        function Patrs(){        
        }
        
        function getParts(){
            if ($this->prts!=null){
                return $this->prts; 
            }
            $query = "SELECT id FROM parts ORDER BY ordinal";
            $res = mQuery($query);
            $this->prts = Array();
            while ($row = mysql_fetch_row($res)){
                $part = new Part($row[0]);
                $this->prts[count($this->prts)] = $part;
            }
            return $this->prts; 
        }
    }
?>
