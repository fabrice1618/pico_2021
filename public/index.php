<?php
//declare(strict_types = 1);

require_once("autoload.php");

date_default_timezone_set('Europe/Paris');

if ( !isset($_SERVER['DOCUMENT_ROOT'])) {
    throw new \Exception("Fatal error: This application must be run in a web environnement.", 1);
}
// Chemin de la base de l'application avec un slash final
$basePath = $_SERVER['DOCUMENT_ROOT'];

$oSession = Session::getInstance();
$oRouter = new Router();


echo "<br>";
echo "<pre>". print_r($oRouter->toArray(), true) . "</pre>";

echo "<br>";
//echo "<pre>". print_r($_SERVER, true) . "</pre>";
//echo "<br>";
echo "<pre>". print_r($_GET, true) . "</pre>";
