<?php
    #можкль отвечает за связь с пользователями
    class UserCommunication{
        public $senderMail;
        public $managerMail;
        
        function UserCommunication(){
        }
        public  function init(){
            $this->senderMail =  $GLOBALS[SENDER_EMAIL];
            $this->managerMail = $GLOBALS[MANAGER_EMAIL];
        }
        public  function sendMailToManager($subject, $message){
            UserCommunication::init();
            return UserCommunication::sendMail($this->managerMail, $this->senderMail, $subject, $message);        
        }
        public function sendMailFmooManager($to,$subject, $message){
            UserCommunication::init();
            return UserCommunication::sendMail($to, $this->managerMail, $subject, $message);
        }
        
        private  function sendMail($to, $from, $subject, $message){
            $headers = 'From: '.$from.'' . "\r\n" .
                'Reply-To: '.$from.'' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            try{
                addlog("mail to $to");
                @mail($to, $subject, $message, $headers);        
            }catch (Exception $e){
                addlog("mail to $to error {$e->getMessage()}");
                return  $e->getMessage();
            }
            return 1;
            
        }        
    }
?>