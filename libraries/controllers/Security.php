<?php
namespace controllers;

class Security{

    public static function session() {
        if(!isset($_SESSION['id_roles'])){
            header("Location: index.php");
        }
    }

    public static function admin() {
        if(!isset($_SESSION['id_roles']) && $_SESSION['id_roles'] !== '1' OR !isset($_SESSION['id_roles']) AND $_SESSION['id_roles'] !== '2' ) {
            header("Location: index.php");
        }
    }
    
    public static function reverse(){
        if(isset($_SESSION['id_roles'])){
            header("Location: index.php");
        }
    }
}