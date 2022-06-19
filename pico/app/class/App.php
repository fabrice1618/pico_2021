<?php

class App
{
    private static $instance = null;
   
    public $session;   // variables session 
    public $request;
    public $response;
    private $router;
    private $controller;
    public $debug;

    private function __construct()
    {
        $this->session = new Session();
        $this->request = new Request();
        $this->response = new Response();
        $this->debug = new Debug();
    }
 
    public function route()
    {
        $this->router = new PicoRouter($this->request);
        $this->router->route_match($this->request, $this->session);
    }

    public function runController()
    {
    $controller_name = $this->router->controller_name;
    $this->controller = new $controller_name( $this->router->action_name );
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new App();  
        
        }
    return( self::$instance );
   }

}