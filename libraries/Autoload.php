<?php //Démmarage du session start ici car ces le premier appel de notre site
// session_start be placed here because is first loading on my page
session_start();
date_default_timezone_set('Europe/paris');
spl_autoload_register(function($className){


    $className = str_replace("\\", "/", $className);
    require_once("./libraries/$className.php");
})

?>
