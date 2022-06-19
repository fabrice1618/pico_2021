<?php

class Debug
{
    public $data;

    public function addDebug($sContent)
    {
        $this->data[] = $sContent;
    }

    public static function runningTimeMs( $nStart )
    {
        return( (microtime(true) - $nStart) * 1000 );
    }

}