<?php 

// 
//   Classe abstraite représentant toutes les intéractions possibles avec une table :
//  
//   On ne veut pas qu'un développeur puisse se dire "Tiens, je vais créer un objet de la classe Model",
//   ça ne veut rien dire car le Model de base ne sait pas à quelle table il s'intéresse.
//
//   On obligera donc le développeur à hériter de cette classe et à préciser le nom de la table concernée

//   English
//   Abstract class , you need extends this class with you controller , you can't create object Model with abstract class
//

namespace models;

abstract class Model
{

    protected $pdo;
    protected $table;
    protected $id;


    //   Constructeur qui vérifie que la table est bien précisée / contruct connexion to bdd
    //   et qui met en place la connexion à la base de données

    public function __construct()
    {
        $this->pdo = \Database::getPdo();
    }

        // Retrouver quelque chose dans cette table par son id et le retourner / find data by id on table and return fetch
       /**
     * find
     *
     * @param  mixed $id
     * @return array
     */
    public function find($id) :?array
    {

        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$this->id}  = ?");
        $query->execute([$id]);
        $result = $query->fetch();

        if(false !== $result){
            return $result;
        }else{
            return null;
        }
    }

    /**
     * Permet de récupérer la liste des données / find all datas from table of bdd and return fetchall
     *
     * @return array
     */
    public function findAll($order = NULL): array
    {
        $sql = "SELECT * FROM {$this->table}";
        if($order){
            $sql .= " ORDER BY " .$order;
        }

        // Retourner tous les articles
        $query = $this->pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll();

    }
      /**
     * findAllBy
     *
     * @param  mixed $col
     * @param  mixed $what
     * @param  mixed $order
     * @return array
     */
    public function findAllBy(string $col, $what, ?string $order = null) :?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$col} = ?";
        if($order){
            $sql .= " ORDER BY " .$order;
        }

        $query = $this->pdo->prepare($sql);
        $query->execute([$what]);
        $result = $query->fetchAll();

        if(false !== $result){
            return $result;
        }else{
            return null;
        }
    }
    

    /**
     * Permet d'insérer un nouvel enregistremen / model for Insert data on database
     *
     * @param string $data
     * @return void
     */
    

    function insert($var1, $var2, $var3, $var4 ) :void
    {
        $query = $this->pdo->prepare("INSERT INTO {$this->table} ({$this->col1}, {$this->col2}, {$this->col3}, {$this->col4}) VALUES (?,?,?,?)");
        $query->execute([$var1, $var2, $var3, $var4]);
    }

    
    /**
     * Permet de supprimer un enregistrement / For deleted data's by id on database
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id) :void
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE {$this->id} = :id");

        $query->execute(['id' => $id]);
    }
}
