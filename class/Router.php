<?php

class Router
{
    private $request_url = null;
    public $request_query_args = null;      // Parametres GET
    public $controller = null;
    public $action = null;
    public $url_args = null;                // Parametres dans l'URL

    public function __construct()
    {

        $this->request_url = $_SERVER ['REQUEST_URI'];
        $this->parseRequestURL();

    }

    /* décompose l'URL REQUEST_URI 
    http://username:password@hostname:9090/path?arg1=value1&arg=value2
    path -> request_path = path
    arg1=value1&arg=value2 -> request_arg=['arg1'=>'value1', 'arg2'=>'value2']
    */
    private function parseRequestURL() 
    {
        $aComponent = parse_url( $this->request_url );

        $aRequestPathParts = $this->parseRequestPath( $aComponent['path'] ?? '/' );
        $this->request_query_args = $this->parseRequestQuery( $aComponent['query'] ?? '' );

        $nCnt = count($aRequestPathParts);
        if ($nCnt == 1) {
            $this->setController( $aRequestPathParts[0] );
        } elseif ($nCnt == 2) {
            $this->setController( $aRequestPathParts[0] );
            $this->setAction( $$aRequestPathParts[1] );
        } elseif ($nCnt > 2) {
            $this->setController( $aRequestPathParts[0] );
            $this->setAction( $$aRequestPathParts[1] );
            $this->url_args = array();
            for( $i=2; $i < $nCnt; $i++) {
                $this->url_args[] = $aRequestPathParts[$i];
            }    
        }

    }

    private function parseRequestPath( $sRequestPath )
    {
        $aParts = array();

        // Supprime un slash au debut de la chaine
        if ( substr($sRequestPath, 0, 1) == '/' ) {
            $sRequestPath = substr($sRequestPath, 1);
        }
        // Supprime un slash à la fin de la chaine
        if ( substr($sRequestPath, -1, 1) == '/' ) {
            $sRequestPath = substr($sRequestPath, 0, strlen($sRequestPath)-1);
        }

        if ( ! empty($sRequestPath) ) {
            foreach ( explode('/', $sRequestPath) as $sPart) {
                $aParts[] = $sPart;            
            }
        }

        return( $aParts );
    }

    // Decomposition de arguments de la requete
    // forme = arg1=value1&arg2=value2
    private function parseRequestQuery( $sRequestQuery )
    {
        $aArguments = array();

        if ( ! empty($sRequestQuery) ) {
            // Decoupe chaque argument de la requete
            foreach ( explode('&', $sRequestQuery) as $sParam) {
                // Decoupe le nom de l'argument et sa valeur
                $aVal = explode('=', $sParam);
                $aArguments[ $aVal[0] ] = $aVal[1];            
            }
        }

        return( $aArguments );
    }

    private function setController( $sControllerName )
    {
        if (!empty($sControllerName) ) {
            $this->controller = $sControllerName;
        }
    }

    private function setAction( $sActionName )
    {
        if (!empty($sActionName) ) {
            $this->action = $sActionName;
        }
    }

    public function toArray()
    {
        return( [
            "request_url" => $this->request_url,
            "url_args" => $this->url_args,
            "request_query_args" => $this->request_query_args,
            "controller" => $this->controller,
            "action" => $this->action
        ]);
    }

}

