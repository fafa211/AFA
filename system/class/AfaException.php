<?php

class AfaException extends Exception{
    
    private $previous;

    public function __construct($message, $code = E_WARNING, $previous = NULL)
    {
        parent::__construct($message, $code, $previous);
        $this->previous = $previous;
    }
    
    
    public function __toString(){
        $message_arr = $this->log();
        if (DEBUG){
            F::tip(join('<br />', $message_arr));
        }
        return $this->getTraceAsString();
    }
    
    public function log(){
        $message_arr = array();
        $logfile = PROROOT.DIRECTORY_SEPARATOR.'runtime'.DIRECTORY_SEPARATOR.'log'.DIRECTORY_SEPARATOR.date('Y-m-d').'.php';
        array_push($message_arr, $this->getMessage(), $this->getCode(), $this->getFile(), $this->getLine(), $this->getPrevious());
        error_log(join("\t", $message_arr), 3, $logfile);
        return $message_arr;
    }
    
    
    public static function instance($e){
        
    }
}