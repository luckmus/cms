<?php
/*
  Описывает базовое сообщение сначала необходимо формировать контетн, а потом JS который будет его обрабатывать

*/
    class Message{
        var $id;
        var $title;
        var $successFnc;                                                                                //имя функции
        var $successFncParam;                                                                           //массив списка параметров
        private $msgText;
        private $ajaxContent;
        private $height = 300;
        private $width = 350;
        private $name;
        private $isAlert = false;
        
        private $msgHTML;
        private $msgJS = null;
        private $successFncCall;
        
        static public function processMsgId($id){
            return "#message$id";
        }
        static public function processMsgTextId($id){
            return "tipsid$id";
        }        
        function Message($id,$title,$msgText,$successFnc,$successFncParam,$ajaxContent){
            $this->id = $id;
            $this->title = $title;
            $this->msgText = $msgText;
            $this->successFnc = $successFnc;
            $this->ajaxContent = $ajaxContent;
            //$this->successFncParam = $successFncParam.split(', ');
            $this->successFncParam = $successFncParam;
            
            $this->msgHTML = '
<div id="message'.$this->id.'" title="'.$this->title.'">
    <p class="validateTips" id="'.Message::processMsgTextId($this->id).'" >'.$this->msgText.'</p>
</div>';
        }
        
        public function setHeight($height){
            $this->height = $height;
        }
        
        public function setWidth($width){
            $this->width = $width;
        }
        public function setIsAlert(){
            $this->isAlert = true;
        }
        public function getHTML(){
            return $this->msgHTML;
        }        
        public function setJS($js){
            $this->msgJS = null;
            $this->getJS();
            $this->msgJS .= $js;
        }                      
        public function getJS(){
            if ($this->msgJS==null){
    $this->msgJS = '
    
    $(function() {

        $( "'.Message::processMsgId($this->id).'" ).dialog( "destroy" );
                

        
        $( "'.Message::processMsgId($this->id).'" ).dialog({
            autoOpen: false,
            height: '.$this->height.',
            width: '.$this->width.',
            modal: true,
            buttons: {';
            if (!$this->isAlert){
                $this->msgJS .= '    
                "Ок": function() {
                  var str = "'.$this->successFnc.'('.$this->successFncParam.')";
                  setTimeout(str,1);
                  $( this ).dialog( "close" );
                },';
                $secondButtomCaption = "Отмена";
            }
            else{
                $secondButtomCaption = "Ok";
            }
             $this->msgJS .= '
                "'.$secondButtomCaption.'": function() {
                    
                    $( this ).dialog( "close" );
                }   
            },
            
            close: function() {            
/*                allFields.val( "" ).removeClass( "ui-state-error" );*/
            }
        });

    });
    $(  "'.Message::processMsgId($this->id).'" ).dialog( "open" ); 
    ';
            }
            return $this->msgJS;
        }
        
        public function getMessageXML1(){

        $xml = '<?xml version="1.0" encoding="windows-1251"?> 
<result>
    <content>'.$this->getHTML().'</content>
    <js>'.$this->getJS().'</js>
    
</result>';
    return $xml;            
        }
        public function getMessageXML(){
            //$this->msgHTML = "1";
            //$this->msgJS="alert('message json');";            
            $html = $this->getHTML();
            $html =   str_replace('"','\"',$html);
            $html =   str_replace("\n",'',$html);
            $html =   str_replace("\r",'',$html);
            $js = $this->getJS();
            $js =   str_replace('"','\"',$js);
            $js =   str_replace("\n",'',$js);
            $js =   str_replace("\r",'',$js);            
  //          $js =   str_replace("\{",'\\{',$js); 
  //          $js =   str_replace("\}",'\\}',$js); 
        $xml = 
        '{
           "content":"'.$html.'",
           "js":"'.$js.'"
        }';
    return $xml;            
        }           
    }
?>