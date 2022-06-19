<?php

/* Utilisation objet Request

print("URI:".$oRequest->uri."<br>");

var_dump( (array)$oRequest );
array(7) { ["Requesturi"]=> string(5) "/toto" ["Requestmethod"]=> string(3) "GET" ["RequestremoteAddr"]=> string(13) "192.168.122.1" ["RequestuserAgent"]=> string(78) "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:101.0) Gecko/20100101 Firefox/101.0" ["Requesttime"]=> float(1655369035.863248) ["Requestpost"]=> array(0) { } ["Requestget"]=> array(0) { } } 

var_dump( $oRequest );
object(Request)#2 (7) { ["uri":"Request":private]=> string(5) "/toto" ["method":"Request":private]=> string(3) "GET" ["remoteAddr":"Request":private]=> string(13) "192.168.122.1" ["userAgent":"Request":private]=> string(78) "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:101.0) Gecko/20100101 Firefox/101.0" ["time":"Request":private]=> float(1655368865.607077) ["post":"Request":private]=> array(0) { } ["get":"Request":private]=> array(0) { } } 
*/

class Request
{
    private $uri = null;
    private $method = null;
    private $remoteAddr = null;
    private $userAgent = null;
    private $time = null;
    private $post;
    private $get;
    private $cookies = null;

    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->remoteAddr = $_SERVER['REMOTE_ADDR'];
        $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
        $this->time = $_SERVER['REQUEST_TIME_FLOAT'];
        $this->post = $this->getPost();
        $this->get = $_GET;
        $this->cookies = $_COOKIE;

    }

    public function __get($sName)
    {
        return($this->$sName);
    }

    // Interdit la modification de la requete
    public function __set( $name, $value )
    {
        throw new Exception(__CLASS__.": Interdit de modifier Request", 1);
    }

    private function getPost()
    {
        if(!empty($_POST)) {
            // when using application/x-www-form-urlencoded or multipart/form-data as the HTTP Content-Type in the request
            // NOTE: if this is the case and $_POST is empty, check the variables_order in php.ini! - it must contain the letter P
            return $_POST;
        }
    
        // when using application/json as the HTTP Content-Type in the request 
        $post = json_decode(file_get_contents('php://input'), true);
        if(json_last_error() == JSON_ERROR_NONE) {
            return $post;
        }
    
        return [];
    }
    
}