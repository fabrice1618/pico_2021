<?php

class Session
{
    private $session = null;   // variables session 

    public function __construct()
    {
        session_start();
        $this->session = $_SESSION;
    }
 
    public function __destruct() 
    {
        session_write_close();
    }

    public function get_csrf_token()
    {
        // générer un token et le stocker dans la session

        return("ABC12345");
    }

    public function isAuth()
    {
        return(false);
    }
 
    public function isAdmin()
    {
     return(false);
    }
}