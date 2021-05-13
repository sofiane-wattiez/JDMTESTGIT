<?php 
namespace controllers;
use \models\Vue;
use \vue\Comments;
use \vue\Article;
use \vue\Users;
use \vue\Tools;
//Ma classe render me sert a afficher mes requetes sql a partir du $_GET
// RENDER used sql request from $_Get for rendering


class Render{

    public static function view(){
        if(isset($_GET['disconnect'])){
            \controllers\Users::disconnect();
        }
        if(isset($_GET['vue']) AND isset($_GET['task'])){
            $Class = "\\vue\\".$_GET["vue"];
            $task  = $_GET['task'];
            if(method_exists($Class, $task)){
                $vue = new $Class;
                $vue->$task();
            }else{
                header("Location:index.php");
            }
        }else{
            $article = new Article();
            $articles =  $article->findAll();

        }
    }
}

