<?php

class Response
{
    private $http_status_code;

    const HTTPcode2message = [
        200 => "HTTP/1.1 200 OK",
        201 => "HTTP/1.1 201 Created",
        302 => "HTTP/1.1 302 Found",
        404 => "HTTP/1.1 404 Not found",
        418 => "HTTP/1.1 418 I am a teapot",
        422 => "HTTP/1.1 422 Unprocessable entity"
    ];

    public function __construct()
    {
        $this->http_status_code = 200;
        ob_start();
    }

    public function send($sContent)
    {
        header(self::HTTPcode2message[$this->http_status_code], true, $this->http_status_code);
        print( $sContent );
        ob_end_flush();
    }

    public function redirect( $sUrl )
    {
        ob_end_clean();
        http_response_code(302);
        header("Location: $sUrl");
    }

    public function setStatusCode( $nCode )
    {
        if ( is_int($nCode) && $nCode >= 100 && $nCode <= 599 ) {
            $this->http_status_code = $nCode;
        }
    }
    
}