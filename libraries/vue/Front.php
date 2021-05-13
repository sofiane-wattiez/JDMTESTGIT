<?php 
namespace vue;
use controllers\Article;
use controllers\Users;
use controllers\Comments;
use \Tools;
use \controllers\Render;
class Front {

    
    public static function menu(){

        
        if(!isset($_SESSION['id_roles'])) : ?>
    
       
        <div class="navheader"> 
            <nav>
                <div class="home">
                    <a href="index.php"><img src="./libraries/assets/home.png"></a>
                </div>
                <?php elseif($_SESSION['id_roles'] == 1) :?>
                    <a class="profilBtn"><div class="profilBtnContent btn btn-outline-primary">
                    <div class="profilBtnTitle">
                        <span><?php  Tools::verifySession('pseudo', 'Profil') ?></span>
                    </div>
                    <div class="profilBtnPhoto">
                        <img src="<?php  Tools::verifySession('avatar', './libraries/assets/users_photo/avatar.jpg') ?>">
                    </div>
                    <?php elseif($_SESSION['id_roles'] == 2) :?>
                        <a class="profilBtn"><div class="profilBtnContent btn btn-outline-primary">
                    <div class="profilBtnTitle">
                        <span><?php  Tools::verifySession('pseudo', 'Profil') ?></span>
                    </div>
                    <div class="profilBtnPhoto">
                        <img src="<?php  Tools::verifySession('avatar', './libraries/assets/users_photo/avatar.jpg') ?>">
                    </div>
                        <?php elseif($_SESSION['id_roles'] == 3) : ?>
                            <a class="profilBtn"><div class="profilBtnContent btn btn-outline-primary">
                    <div class="profilBtnTitle">
                        <span><?php  Tools::verifySession('pseudo', 'Profil') ?></span>
                    </div>
                    <div class="profilBtnPhoto">
                        <img src="<?php  Tools::verifySession('avatar', './libraries/assets/users_photo/avatar.jpg') ?>">
                    </div>
                    <?php endif ; ?>
                </div></a> 
                </div>
                <div class="menu">
                    <div class="link">
                        <?php self::menuLink() ?>
                    </div>
                </div>
            </nav>
        </div> 
    <?php

    } 
    
    public static function menuLink(){

        if(!isset($_SESSION['id_roles'])) : ?>
            <a href="index.php">Acceuil</a>
            <a href="index.php?vue=Users&task=connect">Connexion</a>
            <a href="index.php?vue=Users&task=insertUser">Inscription</a>
        <?php elseif($_SESSION['id_roles'] == 1) :?>
            <a href="index.php">Acceuil</a>
            <a href="index.php?vue=Users&task=update">Profil</a>
            <a href="index.php?vue=Article&task=insert">Création d'article</a>
            <a href="index.php?vue=Users&task=findAll">Liste des utilisateurs</a>
            <a href="index.php?disconnect" onclick="return window.confirm('Etes-vous sûr ?')">Déconnexion</a>

        <?php elseif($_SESSION['id_roles'] == 2) :?>
            <a href="index.php">Acceuil</a>
            <a href="index.php?vue=Users&task=update">Profil</a>
            <a href="index.php?vue=Article&task=insert">Création d'article</a>
            <a href="index.php?vue=Users&task=findAll">Liste des utilisateurs</a>
            <a href="index.php?disconnect" onclick="return window.confirm('Etes-vous sûr ?')">Déconnexion</a>

        <?php elseif($_SESSION['id_roles'] == 3) : ?>
            <a href="index.php">Acceuil</a>
            <a href="index.php?vue=Users&task=update">Profil</a>
            <a href="index.php?disconnect" onclick="return window.confirm('Etes-vous sûr ?')">Déconnexion</a>

        <?php endif ;?>

        <a href="index.php?vue=About&task="></a><?php
    }
    
    public static function header(){
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="libraries/css/style.css">
        <title>JOURNAL DU MEMES</title>
    </head>
        <header>
            <?php self::menu(); ?>
        </header>
            
    <?php
    }

    public static function body(){
        ?>
            <body>
                <h1> LE JOURNAL DU MEME</h1>
                <?php \controllers\Render::view(); ?>
            </body>

            <?php  \Database::disconnect();
    }

    public static function footer(){ ?> 
        <footer><?php
                if(!isset($_SESSION['id_roles'])) :?>
                <a href="index.php">Acceuil</a>
                <a href="index.php?vue=Users&task=connect">Connexion</a>
                <a href="index.php?vue=Users&task=insertUser">Inscription</a>
            <?php elseif($_SESSION['id_roles'] == 1) :?>
                <a href="index.php">Acceuil</a>
                <a href="index.php?vue=Users$task=update">Profil</a>
                <a href="index.php?vue=Article&task=insert">Création d'article</a>
                <a href="index.php?vue=Users&task=findAll">Liste des utilisateurs</a>
                <a href="index.php?disconnect" onclick="return window.confirm('Etes-vous sûr ?')">Déconnexion</a>

            <?php elseif($_SESSION['id_roles'] == 2) :?>
                <a href="index.php">Acceuil</a>
                <a href="index.php?vue=Users$task=update">Profil</a>
                <a href="index.php?vue=Article&task=insert">Création d'article</a>
                <a href="index.php?vue=Users&task=findAll">Liste des utilisateurs</a>
                <a href="index.php?disconnect" onclick="return window.confirm('Etes-vous sûr ?')">Déconnexion</a>

            <?php elseif($_SESSION['id_roles'] == 3) : ?>
                <a href="index.php">Acceuil</a>
                <a href="index.php?vue=Users$task=update">Profil</a>
                <a href="index.php?disconnect" onclick="return window.confirm('Etes-vous sûr ?')">Déconnexion</a>

            <?php endif ;?>
                <a href="index.php?vue=About&task="></a>
        </footer><?php 
    } 

    /**
     * headerAdmin
     *
     * @return void
     */
    public static function headerAdmin(){
    ?>
        <!DOCTYPE html>
            <html lang="en">
                <head>
                <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Document</title>
                    <link href="./assets/css/style.css" rel="stylesheet"> 
                </head>
                <header>
                    <?php self::menu(); ?>
                </header>
            <body>
        </html>
    <?php
    } 

    public static function bodyAdmin(){
    ?>
        <div class="homeAdmin">
            <a href="../index.php">Accueil</a>
        </div>

        <div class="bodyAdm">
            <?php
             \controllers\Render::view();
                $admin = new \vue\Users();
                $admin->insertAdmin();
                \Database::disconnect();
            ?>
        </div>
    <?php
    }

    public static function process(){
        self::header();
        self::body();
        self::footer();
    }

    public static function admin(){
        self::headerAdmin();
        self::bodyAdmin();
        self::footer();
    }

}
