<?php

class HypProcessForm {
    var $to;
    
    /* Constructor */
    function __construct($sendTo) {
        $this->to = $sendTo;
    }

    /* Building the email message to send */
    function buildMsg($arr) {

        $builtMsg = "Name: ". $arr['hcf-name'] ."\nEmail: ". $arr['hcf-email'] ."\nMessage: ". $arr['hcf-message'];

        return $builtMsg;

    }
    
    /* Sending email */
    function email($subject, $message, $from=null , $msg="Thanks! Your message has been sent.") {
        
        try {
            mail($this->to, $subject, $message, "From: $from");
        } catch (\Throwable $th) {
            //throw $th;
            $msg = "Sorry! An error occurs when submitting sur message.";
        }
        
        return $msg;
    }

}

?>