<?php
namespace vue;
use controllers\Security;
use \Tools;
// use controllers\Users;

class Users extends Vue {

    public function findAll(){

        $result = $this->userController->findUsers();?>

        <div class="usersList">
            <div class="usersListTitle">
                <h1>Liste des utilisateurs</h1>
                <p>Il y a actuellement <?=count($result)?> utilisateur<?php Tools::pluralCount($result) ?></p>
                <a href="index.php?vue=Users&task=insertList" class="usersBtn">Ajouter un utilisateur</a>
            </div>
            <?php if(count($result) > 0) :?>
                <div class="usersListTable">
                    <table>
                        <tr>
                            <th>Id</th>
                            <th>Pseudo</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                        <?php foreach($result as $user) :?>
                            <tr>
                                <td data-label="Id"><?=$user['id_users']?></td>
                                <td data-label="Pseudo"><?=$user['pseudo']?></td>
                                <td data-label="Nom"><?=$user['prenom']?></td>
                                <td data-label="Prénom"><?=$user['nom']?></td>
                                <td data-label="Email"><?=$user['email']?></td>
                                <td data-label="Rôle"><?php Tools::roleName($user['id_roles']) ?></td>
                                <td data-label="Modifier"><a class="greenLink" href="index.php?id=<?=$user['id_users']?>&vue=Users&task=updateList">V</a></td>
                                <td data-label="Supprimer"><a class="redLink" href="index.php?delete=delete_from_list&id=<?=$user['id_users']?>&avatar=<?=$user['avatar']?>" onclick="return window.confirm(`Êtes-vous sûr ?`)">X</a></td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                </div>
            <?php endif ?>
        </div><?php
    }

    public function update(){

        if(isset($_GET["delete"])){
            if($_GET['delete']  === 'delete_users'){
                $this->userController->delete();
            }
        }
        $this->userController->updateInfo();
        $this->userController->updatePswd();
        // var_dump($_SESSION);
        ?>
       
        <div class="profil">
            <div class="profilTitle">
                <h1>Profil</h1>
            </div>
            <div class="profilInfo">
                <form action="" enctype="multipart/form-data" method="POST">
                    <div class="profilPhoto">
                        <div class="profilPhotoResult">
                            <img class="profilAvatar" src="<?=$_SESSION['avatar']?>">
                        </div>
                        <div class="profilFileBtn">
                            <label for="file"><img src="./libraries/assets/photo.png"></label>
                            <input type="file" id="file" name="avatar">
                        </div>
                    </div>
                    <div class="profilFormInfo">
                        <div class="profilFormPseudo">
                            <span>Pseudo</span>
                            <input type="text" name="pseudo" value="<?=$_SESSION['pseudo']?>">
                        </div>
                        <div class="profilFormEmail">
                            <span>E-mail</span>
                            <input type="text" name="email" value="<?=$_SESSION['email']?>">
                        </div>
                        <div class="profilFormFirstname">
                            <span>Nom</span>
                            <input type="text" name="prenom" value="<?=$_SESSION['prenom']?>">
                        </div>
                        <div class="profilFormLastname">
                            <span>Prénom</span>
                            <input type="text" name="nom" value="<?=$_SESSION['nom']?>">
                        </div>
                        <div class="profilFormSubmit">
                            <?= $this->userController->message ?>
                            <input class="btnSubmit" type="submit" name="infoSubmit" value="Modifier">
                        </div>
                    </div>
                </form>
            </div>
            <div class="profilFormPasswd">
                <form method="POST">
                    <div class="profilPasswd1">
                        <span>Ancien mot de passe</span>
                        <input type="password" name="passwd1">
                    </div>
                    <div class="profilPasswd2">
                        <span>Nouveau mot de passe</span>
                        <input type="password" name="passwd2">
                    </div>
                    <div class="profilPasswd3">
                        <span>Confirmation mot de passe</span>
                        <input type="password" name="passwd3">
                    </div>
                    <div class="profilPasswdSubmit">
                        <p><?= $this->userController->messagePass ?></p><br>
                        <input class="btnSubmit" type="submit" name="passwdSubmit" value="Modifier">
                    </div>
                    <div class="deleteUser">
                        <a href="index.php?vue=Users&task=update&delete=delete_users" onclick="return window.confirm(`Êtes-vous sûr ?`)">Supprimer le compte</a>
                    </div>
                </form>
            </div>
        </div><?php
    }



    public function updateList(){

        $user = $this->userController->updateList($_GET['id_users']);?>

        <div class="userForm">
            <div class="userFormTitle">
                <h1>Modification de l'utilisateur : <?= $user['pseudo'] ?></h1>
            </div>
            <div class="userFormBody">
                <form action="" method="POST">
                    <div class="userFormPseudo">
                        <span>Pseudo</span>
                        <input type="text" name="pseudo" value="<?= $user['pseudo'] ?>">
                    </div>
                    <div class="userFormEmail">
                        <span>E-mail</span>
                        <input type="text" name="email" value="<?= $user['email'] ?>">
                    </div>
                    <div class="userFormFirstname">
                        <span>Nom</span>
                        <input type="text" name="prenom" value="<?= $user['prenom'] ?>">
                    </div>
                    <div class="userFormLastname">
                        <span>Prénom</span>
                        <input type="text" name="nom" value="<?= $user['nom'] ?>">
                    </div>
                    <div class="userFormRole">
                        <span>Role</span> 
                        <select name="id_roles">
                            <option value="1" <?php Tools::optionSelected($user['id_roles'], 1) ?>>Super_Admin</option>
                            <option value="2" <?php Tools::optionSelected($user['id_roles'], 2) ?>>Administrateur</option>
                            <option value="3" <?php Tools::optionSelected($user['id_roles'], 3) ?>>Utilisateur</option>
                        </select>
                    </div>
                    <div class="userFormMessage">
                        <p><?= $this->userController->message ?></p>
                    </div>
                    <div class="userFormSubmit">
                        <input type="submit" name="submit" value="Modifier" class="btnSubmit">
                    </div>
                </form>
            </div>
        </div><?php
    }
    
    /**
     * connect
     *
     * @return void
     */
    public function connect(){

        Security::reverse();
        $this->userController->connect(); ?>
    
            <div class="connection">
                <form action="" method="POST">
                    <h1>Connexion</h1>
                        <div class="form-pseudo">
                            <label for="pseudo">Pseudo : </label>
                            <input type="text" name="pseudo" value="<?php Tools::sendInput('pseudo') ?>">
                        </div>
                        <div class="form-psw">
                            <label for="password">Mot de passe :</label>
                            <input type="password" name="passwd" placeholder="Votre mot de passe" <?php Tools::sendInput('passwd') ?> />
                        </div>
                        <div class="connexionMessage">
                        <?= $this->userController->message ?>
                        </div>
                        <div class="connexionRedirect">
                        <p>Pas de compte ? <a href="index.php?vue=Users&task=insertUser">Inscrivez-vous !</a></p>
                        </div>
                         <!-- <div class="form-psw">
                            <label for="password">Mot de passe Oublié:</label>
                            <input type="password" name="password" placeholder="Votre mot de passe" Tools::sendInput('password')  // />
                        </div>  -->
                    <div class="connectsubmit">
                        <input type="submit" value="Envoyer" name="submit" class="btnSubmit"> 
                    </div>
                </form>
            </div>
        <?php
        }
    
    /**
     * insertUser
     *
     * @return void
     */
    public function insertUser(){
        



        Security::reverse();
         $this->userController->insert(3);?>

        <div class="inscription">
            <div class="inscriptionTitle">
                <h1>Inscription</h1>
            </div>
            <div class="inscriptionForm">
                <form action="" method="POST">
                    <div class="inscriptionPseudo">
                        <span>Pseudo</span><br>
                        <input type="text" name="pseudo" value="<?php Tools::sendInput('pseudo') ?>">
                    </div>
                    <div class="inscriptionPrenom">
                        <span>Nom</span><br>
                        <input type="text" name="prenom" value="<?php Tools::sendInput('prenom') ?>">
                    </div>
                    <div class="inscriptionNom">
                        <span>Prénom</span><br>
                        <input type="text" name="nom" value="<?php Tools::sendInput('nom') ?>">
                    </div>
                    <div class="inscriptionEmail">
                        <span>E-mail</span><br>
                        <input type="email" name="email" value="<?php Tools::sendInput('email') ?>">
                    </div>
                    <div class="inscriptionEmail2">
                        <span>Confirmation de l'e-mail</span><br>
                        <input type="email" name="email2" value="<?php Tools::sendInput('email2') ?>">
                    </div>
                    <div class="inscriptionPasswd">
                        <span>Mot de passe</span><br>
                        <input type="password" name="passwd">
                    </div>
                    <div class="inscriptionPasswd2">
                        <span>Confirmation du mot de passe</span><br>
                        <input type="password" name="passwd2">
                    </div>
                    <div class="inscriptionMessage">
                        <p> <?php  $this->userController->message ?> </p>
                    </div>
                    <div class="inscriptionRedirect">
                        <p>Déjà inscrit ? <a href="index.php?vue=Users&task=connect">Connectez-vous !</a></p>
                    </div>
                    <div class="inscriptionSubmit">
                        <input type="submit" value="Envoyer" class="inscriptionSubmitBtn" name="submit">
                        <input type="reset" class="btnSubmit">
                    </div>
                </form>
            </div>
        </div><?php

    }

    public function insertAdmin(){

        $this->userController->insert(2);?>

        <div class="inscription">
            <div class="inscriptionTitle">
                <h1>Inscription Administrateur</h1>
            </div>
            <div class="inscriptionForm">
                <form action="" method="POST">
                    <div class="inscriptionPseudo">
                        <span>Pseudo</span><br>
                        <input type="text" name="pseudo">
                    </div>
                    <div class="inscriptionFirstName">
                        <span>Nom</span><br>
                        <input type="text" name="firstname">
                    </div>
                    <div class="inscriptionLastName">
                        <span>Prénom</span><br>
                        <input type="text" name="lastname">
                    </div>
                    <div class="inscriptionEmail">
                        <span>E-mail</span><br>
                        <input type="email" name="email">
                    </div>
                    <div class="inscriptionEmail2">
                        <span>Confirmation de l'e-mail</span><br>
                        <input type="email" name="email2">
                    </div>
                    <div class="inscriptionPasswd">
                        <span>Mot de passe</span><br>
                        <input type="password" name="passwd">
                    </div>
                    <div class="inscriptionPasswd2">
                        <span>Confirmation du mot de passe</span><br>
                        <input type="password" name="passwd2">
                    </div>
                    <div class="inscriptionMessage">
                        <p><?=$this->userController->message?></p>
                    </div>
                    <div class="inscriptionSubmit">
                        <input type="submit" value="Envoyer" class="inscriptionSubmitBtn btn btn-primary"
                            name="submit">
                        <input type="reset" class="btn btn-dark">
                    </div>
                </form>
            </div>
        </div><?php
    }
    public function insertList(){
        $this->userController->insertList();?>
        <div class="inscriptionList">
            <div class="inscriptionListTitle">
                <h1>Ajouter un utilisateur</h1>
            </div>
            <div class="inscriptionListForm">
                <form action="" method="post">
                    <div class="inscriptionListFormPseudo">
                        <span>Pseudo</span>
                        <input type="text" name="pseudo" value="<?=Tools::sendInput("pseudo")?>">
                    </div>
                    <div class="inscriptionListFormFirstname">
                        <span>Nom</span>
                        <input type="text" name="prenom" value="<?=Tools::sendInput("prenom")?>">
                    </div>
                    <div class="inscriptionListFormLastname">
                        <span>Prénom</span>
                        <input type="text" name="nom" value="<?=Tools::sendInput("nom")?>">
                    </div>
                    <div class="inscriptionListFormMail">
                        <span>Email</span>
                        <input type="email" name="email" value="<?=Tools::sendInput("email")?>">
                    </div>
                    <div class="inscriptionListFormPasswd">
                        <span>Mot de passe</span>
                        <input type="password" name="passwd">
                    </div>
                    <div class="inscriptionListFormRole">
                        <span>Rôle</span>
                        <select name="id_roles">
                            <option value="1" <?=Tools::optionSelectedPost("role", "1")?>>Super_Administrateur</option>
                            <option value="2" <?=Tools::optionSelectedPost("role", "2")?>>Administrateur</option>
                            <option value="3" <?=Tools::optionSelectedPost("role", "3")?>>Utilisateur</option>
                        </select>
                    </div>
                    <div class="inscriptionListFormMessage">
                        <p><?= $this->userController->message ?></p>
                    </div>
                    <div class="inscriptionListFormSubmit">
                        <input type="submit" class="btn btn-primary" name="submit" value="Envoyer">
                    </div>
                </form>
            </div>
        </div>
        <?php
    }

}