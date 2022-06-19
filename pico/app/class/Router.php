<?php

class Router
{
    protected $path_parts = [];                // Parametres dans l'URL

    /*
    protected function parseRequestURI( $sRequestUri )
    {
        $aComponent = parse_url( $sRequestUri );
        $sRequestPath = $aComponent['path'] ?? '/';

        // Supprime un slash au debut de la chaine
        if ( substr($sRequestPath, 0, 1) == '/' ) {
            $sRequestPath = substr($sRequestPath, 1);
        }
        // Supprime un slash à la fin de la chaine
        if ( substr($sRequestPath, -1, 1) == '/' ) {
            $sRequestPath = substr($sRequestPath, 0, strlen($sRequestPath)-1);
        }

        if ( ! empty($sRequestPath) ) {
            $this->path_parts = explode('/', $sRequestPath);
        } else {
            $this->path_parts = [];
        }
    }*/

    protected function explode_URI( $sUri )
    {
//        print("explode_uri: $sUri\n");

        $aComponent = parse_url( $sUri );
        $sRequestPath = $aComponent['path'] ?? '/';

        // Supprime un slash au debut de la chaine
        if ( substr($sRequestPath, 0, 1) == '/' ) {
            $sRequestPath = substr($sRequestPath, 1);
        }
        // Supprime un slash à la fin de la chaine
        if ( substr($sRequestPath, -1, 1) == '/' ) {
            $sRequestPath = substr($sRequestPath, 0, strlen($sRequestPath)-1);
        }

        if ( ! empty($sRequestPath) ) {
            $aParts = explode('/', $sRequestPath);
        } else {
            $aParts = [];
        }

//        print_r($aParts);
        
        return($aParts);
    }

}

