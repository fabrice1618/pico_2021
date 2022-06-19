<?php
//declare(strict_types = 1);

require_once("../app/autoload.php");

date_default_timezone_set('Europe/Paris');

// $basePath : Chemin de la base de l'application avec un slash final
if ( !isset($_SERVER['DOCUMENT_ROOT'])) {
    throw new \Exception("Fatal error: \$_SERVER['DOCUMENT_ROOT'] is not set", 1);
}
$basePath = $_SERVER['DOCUMENT_ROOT'];

$app = App::getInstance();

$app->route();
$app->runController();
