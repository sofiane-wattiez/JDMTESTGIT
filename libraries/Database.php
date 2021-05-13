<?php
//  La classe est abstraite car on ne veut pas qu'un développeur distrait puisse créer
 // un objet issu de cette classe.
use \PDO;
use \PDOException;
 
abstract class Database extends \admin\Info{

     
    private static $pdo;

   
    public static function getPdo(): PDO
    {

        if(self::$pdo === null){

            try{
                self::$pdo = new PDO("mysql:host=".self::DB_HOST.";dbname=".self::DB_NAME.";charset=utf8", self::DB_USER, self::DB_PASS,[
                PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC
                ]);
            }
            catch (PDOException $e) {
                $e = utf8_encode($e->getMessage());
                die("<span style='color:white'>Échec lors de la connexion : ".$e."</span>");
            }

        }
    
        return self::$pdo;
    }
        /**
        * disconnect
        *
        * @return void
        */
       
        public static function disconnect() :void
        {
            if(self::$pdo !== null){
    
                self::$pdo = null;
    
            }
    }

    
}
