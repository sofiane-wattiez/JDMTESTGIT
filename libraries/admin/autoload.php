<?php
spl_autoload_register(function($className){
    $className = str_replace("\\", "/", "../".$className).".php";
    if(file_exists($className)){
        require_once $className;
    }else{
        header('Location: index.php');
    }
});