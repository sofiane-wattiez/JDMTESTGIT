<?php
namespace models;
use \Tools;

class Users extends Model {

    protected $table = "users";
    protected $id = "id_users";
    protected $pseudo = "pseudo";
    protected $passwd = "passwd";
    protected $role = "id_roles";
    protected $avatar = "avatar";
    



    // public function __construct(){
    //     parent::__construct();
    //     $this->model    = new \models\Users;
    //     $this->message      = Tools::message("message", "light not");
    //     $this->messagePass  = Tools::message("message", "light not");
    // }


    //Cette function sert a vérifié si j'ai plusieurs fois si j'ai les meme entrée pseudo ou email dans ma database /
    //This function is used for verify if i have same entry pseudo or email in my database
    function verify(string $pseudo, string $email) :int
    {
        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE pseudo = ? OR email = ?");
        $query->execute([$pseudo, $email]);
        $result = $query->rowCount();

        return $result;
    }
    // cette fonction me sert a me connecter a partir du pseudo comme identifiant
    //this function is used for connect me  from pseudo as login

    function connect(string $pseudo) :?array {
        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE pseudo = ?");
        $query->execute([$pseudo]);
        $result = $query->fetch();

        return $result;
    }
    // Mise a jours de plusieurs données dans la table users dans la table articles /
    // update data from table users on database
    function updateInfo( $pseudo, $email, $prenom, $nom, $avatar, $id) :bool
    {
        $update = $this->pdo->prepare("UPDATE {$this->table} SET  pseudo = ?, email = ?, prenom = ?, nom = ?, avatar = ? WHERE {$this->id} = ?");
        $update->execute([ $pseudo, $email, $prenom, $nom, $avatar, $id]);

        return true;
    }
    // Mise a jours de mots de passe  on le met à part car on va le hacher avec une autre function pour le sécurisé.
    // Update password alone request because we hash this data in other function

    function updatePswd($passwd, $id) :bool
    {
        $update = $this->pdo->prepare("UPDATE {$this->table} SET passwd = ? WHERE {$this->id} = ?");
        $update->execute([$passwd, $id]);

        return true;
    }
    //Nous allons rentrer les données d'un nouvelle utilisateurs lors de son inscription 
    // We insert data from users when he create account , data going to table users
    function insertUser(int $role, string $pseudo, string  $prenom, string $nom, string $email, string $passwd) :bool
    {
        $insert = $this->pdo->prepare("INSERT INTO users (id_roles, pseudo, prenom, nom, email, passwd, avatar) VALUES (?,?,?,?,?,?,?)");
        $insert->execute([$role, $pseudo, $prenom, $nom, $email,$passwd , "./libraries/assets/users_photo/avatar.jpg" ]);

        return true;
    }

}

?>