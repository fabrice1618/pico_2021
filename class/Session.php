<?php

class Session
{
    private static $instance = null;
   
    private $session = null;   // variables session 
    private $cookies = null;
    private $remote_addr = null;

    private function __construct()
    {
        session_start();
        $this->session = $_SESSION;
        $this->cookies = $_COOKIE;
        $this->remote_addr = $_SERVER['REMOTE_ADDR'];

    }
 
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Session();  
        
        }
    return( self::$instance );
   }
    
}