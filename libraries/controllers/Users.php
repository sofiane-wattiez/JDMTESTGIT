<?php 
namespace controllers;
use \Tools;

// use controllers\Controller;
// use models\Article;



class Users extends Controller {

    // public function __construct(){
    //     parent::__construct();
    // }
    

    public function __construct(){
        $this->model    = new \models\Users;
        $this->message      = Tools::message("message", "light not");
        $this->messagePass  = Tools::message("message", "light not");
    }

    // public function findUsers(int $id){
        
    //     \controllers\Security::admin();

    //     $user = $this->model->findUsers($id,$id_roles);

    //     if($_SESSION['id_roles'] === '1' OR $_SESSION['id_roles'] === '2' ){
    //         header('Location:Location:index?vue=Users&task=connect.php');
    //     }elseif($_SESSION['id_roles'] === '3'){
    //         header('Location:index?vue=Users&task=connect.php');
    //     }if(false === $result){
    //         $error = "<p class='white'>L'utilisateur demandé n'existe pas !</p>" ;
    //         die($error);
    //     }
    //     return $result;

    // }

    public function findUsers($id = null){
        \controllers\Security::admin();

        if(!$id){
            $result = $this->model->findAll();
        }else{
            $result = $this->model->find($id);
            if(false === $result){
                $error = "
                <p class='white'>L'utilisateur demandé n'existe pas !</p>
                ";
                die($error);
            }
        }
        return $result;
    }



    public function  findAll(string $order = NULL) :array{
        
        $users = $user->findAll($order);
        return $users;
       
    }

    public function connect(){
        if(isset($_POST['submit'])){
            $pseudo = Tools::safe_input($_POST['pseudo']);
            $passwd = Tools::safe_input($_POST['passwd']);

            if(!empty($pseudo) AND !empty($passwd)){

                $result = $this->model->connect($pseudo);

                if($result !== false){

                    if(password_verify($passwd, $result['passwd'])){
                        //supprime la clé passwd du $result avant de l'envoyer dans le $_SESSION pour plus de sécurité 
                        unset($result['passwd']);
                        $_SESSION = $result;
                        
                        $this->message = Tools::message("Connection réussie !", "success");

                        header("refresh: 1; url=index.php");
                    }else{
                        $this->message = Tools::message("Veuillez entrer un mot de passe valide !");
                    }
                }else{
                    $this->message = Tools::message("Veuillez entrer un pseudo valide !");
                }
            }else{
                $this->message = Tools::message("Veuillez remplir TOUS les champs !");
            }
        }
    }

    public function insert(int $role){


        if(isset($_POST['submit'])){
            $pseudo = Tools::safe_input($_POST['pseudo']);
            $prenom = Tools::safe_input($_POST['prenom']);
            $nom = Tools::safe_input($_POST['nom']);
            $email = Tools::safe_input($_POST['email']);
            $email2 = Tools::safe_input($_POST['email2']);
            $passwd = Tools::safe_input($_POST['passwd']);
            $passwd2 = Tools::safe_input($_POST['passwd2']);
            
            if(!empty($pseudo) AND !empty($prenom) AND !empty($nom) AND !empty($email) AND !empty($email2) AND !empty($passwd) AND !empty($passwd2)){
                // Sert a définir des charachtere obligatoire a mettre dans un input , trés utilisé pour augmenté la sécurité es email
                if(preg_match( " /^.+@.+\.[a-zA-Z]{2,}$/ " , $email) AND preg_match( " /^.+@.+\.[a-zA-Z]{2,}$/ " , $email2)){

                    if($email === $email2){
        
                        if($passwd === $passwd2){
        
                            $passwd = Tools::passHash($passwd);
                            $result = $this->model->verify($pseudo, $email);
        
                            if(($result == 0)){
                                                        // test a réaliser avec $data $role, $pseudo, $prenom, $nom, $email, $passwd ,$id
                                $this->model->insertUser($role, $pseudo, $prenom, $nom, $email, $passwd);
        
                                // Refresh me sert a mettre un petit délais avant de refresh mon url aprés mon méssage de validation 
                                $this->message = Tools::message("Inscrition réussie !", "success");
                                if($role == 3){
                                    header("refresh: 1; url=./index.php?vue=Users&task=connect");
                                }
                                elseif($role == 2){
                                    header("refresh: 1; url=./index.php?vue=Users&task=connect");
                                }elseif($role == 1){
                                    header("refresh: 1; url=./index.php?vue=Users&task=connect");
                                }
                            }else{
                                $this->message = Tools::message("Pseudo ou e-mail déjà utilisés !");
                            }
                        }else{
                            $this->message = Tools::message("Les mots de passe de correspondent pas !");
                        }
                    }else{
                        $this->message = Tools::message("Les adresses e-mail ne correspondent pas !");
                    }
                }else{
                    $this->message = Tools::message("Veuillez entrer une adresse e-mail valide !");
                }
            }else{
                $this->message = Tools::message("Veuillez remplir TOUS les champs !");
            }
        }
    }
    
     public function insertList(){

        \controllers\Security::admin();
        if(isset($_POST["submit"])){
            $pseudo = Tools::safe_input($_POST['pseudo']);
            $prenom = Tools::safe_input($_POST['prenom']);
            $nom = Tools::safe_input($_POST['nom']);
            $email = Tools::safe_input($_POST['email']);
            $passwd = Tools::safe_input($_POST['passwd']);
            $role = Tools::safe_input(intval($_POST["id_roles"]));
            if(!empty($pseudo) AND !empty($prenom) AND !empty($nom) AND !empty($email) AND !empty($passwd)){

                if(preg_match( " /^.+@.+\.[a-zA-Z]{2,}$/ " , $email)){

                    $result = $this->model->verify($pseudo, $email);

                    if(($result == 0)){
                        $passwd = Tools::passHash($passwd);
                        $this->model->insertUser($role, $pseudo, $prenom, $nom, $email, $passwd);

                        $this->message = Tools::message("Utilisateur inscrit !", "success");

                        header("refresh: 1; url=index.php?vue=Users&task=findAll");

                    }else{
                        $this->message = Tools::message("Pseudo ou e-mail déjà utilisés !");
                    }
                }else{
                    $this->message = Tools::message("Veuillez entrer une adresse e-mail valide !");
                }
            }else{
                $this->message = Tools::message("Veuillez remplir TOUS les champs !");
            }
            
        }
    }

    public function updateInfo(){
        \controllers\Security::session();
        $avatar = $_SESSION['avatar'];

        if(isset($_POST['infoSubmit'])){
            if(!empty($_POST['pseudo']) AND !empty($_POST['email']) AND !empty($_POST['prenom']) AND !empty($_POST['nom'])){
                
                $pseudo = Tools::safe_input($_POST['pseudo']);
                $email = Tools::safe_input($_POST['email']);
                $prenom = Tools::safe_input($_POST['prenom']);
                $nom = Tools::safe_input($_POST['nom']);    

                if(preg_match( " /^.+@.+\.[a-zA-Z]{2,}$/ " , $email)){

                    if(isset($_FILES['avatar'])){
                        
                        if(!empty($_FILES['avatar']['name'])){

                            $info = pathinfo($_FILES['avatar']['type']);

                            $extension = array('jpg', 'jpeg', 'png', 'gif');

                            //a vérifier 
                            if(in_array($info['basename'], $extension)){
                                if($_FILES['avatar']['size'] <= 2000000){
                                    if($_SESSION['avatar'] !== './libraries/assets/users_photo/avatar.jpg' AND $_SESSION['avatar'] !== NULL     ){
                                        unlink($_SESSION['avatar']);
                                    }

                                    $avatar = "./libraries/assets/users_photo/".$_SESSION['id'].".".$info['basename'];
                                    
                                    $stock = move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar);
                                    // var_dump($stock); die();

                                    if(!$stock){
                                        $this->message = Tools::message("La photo n'a pas été envoyé");
                                    }

                                }else{
                                    $this->message = Tools::message("La taille de l'image ne doit pas dépasser 2Mo !");
                                }

                            }else{
                                $this->message = Tools::message("Le fichier sélectionné n'est pas au bon format !");
                            }
                        }
                    }
                    
                    $verify = $this->model->verify($pseudo, $email);

                    if($verify <= 1){
                        $update = $this->model->updateInfo($pseudo, $email, $prenom, $nom, $avatar, $_SESSION['id']);

                        if($update === true){
                            $_SESSION['pseudo'] = $pseudo;
                            $_SESSION['email'] = $email;
                            $_SESSION['prenom'] = $prenom;
                            $_SESSION['nom'] = $nom;
                            $_SESSION['avatar'] = $avatar;

                            $this->message = Tools::message("Vos informations ont bien été modifié", "success");
                            header("refresh: 2;");
                        }else{
                            $this->message = Tools::message("Une erreur est survenu, veuillez ressayer !");
                        }
                    }else{
                        $this->message = Tools::message("Pseudo ou e-mail déjà utilisé !");
                    }
                }else{
                    $this->message = Tools::message("Veuillez entrer une adresse e-mail valide !");
                }                       
            }else{
                $this->message = Tools::message("Veuillez remplir TOUS les champs !");
            }
        }
    }
        
                
                
    



    public function updatePswd(){
        \controllers\Security::session();
        if(isset($_POST['passwdSubmit'])){
            $passwd1 = Tools::safe_input($_POST['passwd1']);
            $passwd2 = Tools::safe_input($_POST['passwd2']);
            $passwd3 = Tools::safe_input($_POST['passwd3']);
        
            if(!empty($passwd1) AND !empty($passwd2) AND !empty($passwd3)){
                $result = $this->model->connect($_SESSION['pseudo']);
        
                if(password_verify($passwd1, $result['passwd'])){
                    if($passwd2 === $passwd3){
                        $passwd2 = Tools::passHash($passwd2);
        
                        $this->model->updatePswd($passwd2, $_SESSION['id']);
        
                        $this->messagePass = Tools::message("Votre mot de passe a bien été modifié", "success");
        
                        header("refresh: 1; url=index.php?vue=Users&task=update");
                    }else{
                        $this->messagePass = Tools::message("Les nouveaux mot de passe ne correspondent pas !");
                    }
                }else{
                    $this->messagePass = Tools::message("Veuillez entrer le bon mot de passe !");
                }
            }else{
                $this->messagePass = Tools::message("Veuillez remplir TOUS les champs !");
            }
        }
    }
    



    public function updateList($id){

        \controllers\Security::admin();

        $user = $this->findUsers($id);

        if(isset($_POST['submit'])){
            if(!empty($_POST['pseudo']) AND !empty($_POST['email']) AND !empty($_POST['prenom']) AND !empty($_POST['nom'])){
        
                $getId = Tools::safe_input($_GET['id']);
                $role = ($getId === $_SESSION['id']) ? $role = $_SESSION['id_roles'] : Tools::safe_input($_POST['roles']);
                $pseudo = Tools::safe_input($_POST['pseudo']);
                $email = Tools::safe_input($_POST['email']);
                $prenom = Tools::safe_input($_POST['prenom']);
                $nom = Tools::safe_input($_POST['nom']);
                $avatar = $user['avatar'];
                
                if(preg_match( " /^.+@.+\.[a-zA-Z]{2,}$/ " , $email)){
                    //verification si on trouve nos information dans la base de données 
                    $verify = $this->model->verify($pseudo, $email);
                    if($verify >= 1){
                        $update = $this->model->updateInfo($role, $pseudo, $email, $prenom, $nom, $avatar, $getId);
            
                        if($update === true){
                            if($getId === $_SESSION['id']){
                                $_SESSION['pseudo'] = $pseudo;
                                $_SESSION['prenom'] = $prenom;
                                $_SESSION['nom'] = $nom;
                                $_SESSION['email'] = $email;
                               $_SESSION['id_roles'] = $role;
                            }
            
                            $this->message = Tools::message("Les informations ont bien été modifié", "success");
                            header("refresh: 1;");
                        }else{
                            $this->message = Tools::message("Une erreur est survenu, veuillez ressayer !");
                        }
                    }else{
                        $this->message = Tools::message("Pseudo ou e-mail déjà utilisé !");
                    }
                }else{
                    $this->message = Tools::message("Veuillez entrer une adresse e-mail valide !");
                }
            }else{
                $this->message = Tools::message("Veuillez remplir TOUS les champs !");
            }
        }
        return $user;
    }


    public static function disconnect(){
        if(isset($_GET['disconnect'])){
            session_unset();
            session_destroy();
            unset($_SESSION);
            header("Location: index.php");
            exit;
        }
    }



}
?>