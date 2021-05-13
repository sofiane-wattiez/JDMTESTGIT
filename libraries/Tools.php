<?php
class Tools{
    // récuperer la clé dans un input
    //
    public static function sendInput($key){
        if(isset($_POST[$key])){
            echo $_POST[$key];
        }

    }
    // Hashage du mdp // password hash
    public static function passHash($passwd){
        $passwd = password_hash($passwd, PASSWORD_BCRYPT);
    
        return $passwd;
    }
    public static function verifySession($key, $no = null){
        if(isset($_SESSION[$key])){
            echo $_SESSION[$key];
        }else{
            echo $no;
        }
    }
    public static function deleteInDir($dir){
        $repertoire = opendir($dir);
        while(false !== ($fichier = readdir($repertoire))){
            if($fichier != "." AND $fichier != ".." AND !is_dir($fichier))
            unlink($dir ."/". $fichier);
        }
        closedir($repertoire);
    }
    public static function roleName($role){
        if($role === '1'){
            echo 'Super_Admin';
        }elseif($role === '2'){
            echo 'Admin';
        }elseif($role === '3'){
            echo 'Users';
        }
    }
    public static function pluralCount(array $var){
        if(count($var) > 1){
            echo "s";
        }
    }

    public static function optionSelected($var, int $i){
        if($var == $i){
            echo "selected";
        }
    }
    public static function optionSelectedPost($key, int $i){
        if(isset($_POST[$key])){
            if($_POST[$key] == $i){
                echo "selected";
            }
        }
    }
    public static function photoGet($var){
        if(!is_null($var['image_article'])){
            echo "&image_article=".$var['image_article'];
        }
    }
    public static function safe_input($input){
        //trim — Supprime les espaces (ou d'autres caractères) en début et fin de chaîne
        $input = trim($input);
        //stripslashes — Supprime les antislashs d'une chaînes
        $input = stripslashes($input);
        //htmlspecialchars — Convertit les caractères spéciaux en entités HTML
        $input = htmlspecialchars($input);
        // strip_tags() tente de retourner la chaîne string après avoir supprimé tous les octets nuls, toutes les balises PHP et HTML du code.
        //Elle génère des alertes si les balises sont incomplètes ou erronées. Elle utilise le même moteur de recherche que fgetss().
        $input = strip_tags($input);
        return $input;
    }
    public static function message($message, $color = "danger"){
        $error = "<p class='alert alert-{$color}' role='alert'>{$message}</p>";
        return $error;

    }
}