<?php 
namespace controllers;

use \Tools;

// use controllers\Controller;
// use models\Article;



class Article extends Controller {
    protected $modelName = "\model\Article";
    protected $id = "id_articles";

    
    public function __construct(){
        // parent::__construct();
        $this->model = new \models\Article();
        $this->message      = Tools::message("message", "light not");

    }

    
 
    public function  findAll(string $order = NULL) :array{

        $articles = $this->model->findAll($order);
        // dump($articles);
        return $articles;

    }

    /**
     * on va allez chercher l'identifiant de l'article a partir d'une requete find du model
     * find id from article from table articles / for find we used sql request from model
     *
     * @param  mixed $id
     * @return array
     */
    public function find($id) :array{

        $articleSolo = $this->model->find($id);
        if(false === $articleSolo){
            $error = Tools::message("L'article demandé n'existe pas !", "light");
            die($error);
        }

        return $articleSolo;
    }
       
     /**
     * Mise a jours des données relatif au articles dans la table articles.
     * Update data's from articles table  
     *
     * @param  mixed $id
     * @return array
     */
    public function update($id) :array{
        \controllers\Security::admin();
        $articleSolo = $this->find($id);

        if(isset($_POST['articleUpdatePhotoDel'])){
            if(!is_null($articleSolo['image_article'])){
                $this->model->updateOne( "image_article", $id);
                unlink($articleSolo['image_article']);

                $this->message = "<p class='succes'>Photo supprimée !</p>";

                header("refresh:1");
            }
        }
         //nom de l'input
        if(isset($_POST['articleUpdateSubmit'])){
            if(!empty($_POST['articleUpdateTitle']) AND !empty($_POST['articleUpdateContent'])){
                //safe input et un cumul de plusieurs function de sécurité pour protégé mes input
                //safe input is used for sécurized input with 3  security function.
                $title   = Tools::safe_input($_POST['articleUpdateTitle']);
                $content = Tools::safe_input($_POST['articleUpdateContent']);
                $image_article   = $articleSolo['image_article'];
                $date    = date('Y-m-d H:i:s');

                if(isset($_FILES['articleUpdateFile'])){
                    if(!empty($_FILES['articleUpdateFile']['name'])){

                        $info = pathinfo($_FILES['articleUpdateFile']['type']);

                        $extension = array('jpg', 'jpeg', 'png', 'gif');

                        if(in_array($info['basename'], $extension)){
                            if($_FILES['articleUpdateFile']['size'] <= 2000000){

                                if(!is_null($image_article)){
                                    unlink($image_article);
                                    $image_article = null;
                                }

                                $image_articleName = str_replace(" ", "_", $title);

                                $image_article = "./libraries/assets/article/".$image_articleName."-".$_FILES['articleUpdateFile']['name'];
                                
                                $stock = move_uploaded_file($_FILES['articleUpdateFile']['tmp_name'], $image_article);

                                if(!$stock){
                                    $this->message = Tools::message("La photo n'a pas été envoyé", "success");
                                }

                            }else{
                                $this->message = Tools::message("La taille de l'image ne doit pas dépasser 2Mo");
                            }

                        }else{
                            $this->message = Tools::message("Le fichier sélectionné n'est pas au bon format");
                        }
                    }
                }

                $this->model->update($title, $content, $image_article, $date, $id);

                $this->message = Tools::message("Article modifié !", "success");

                header("refresh:1;");

            }else{
                $this->message = Tools::message("Veuillez remplir TOUS les champs !");
            }
        }
        return $articleSolo;
    }

    /**
     * Je veut inserer des données dans ma table articles
     * I want insert data in my articles table
     *
     * @return void
     */
    public function insert() :void {
        
        \controllers\Security::admin();
        $image_article = null;

        if(isset($_POST['deletePhoto'])){
            Tools::deleteInDir('./libraries/assets/article/temporary');
        }

        if(isset($_POST['articleSubmit'])){

            if(!empty($_POST['articleTitle']) AND !empty($_POST['articleContent'])){

                $title = Tools::safe_input($_POST['articleTitle']);
                $content = Tools::safe_input($_POST['articleContent']);
                $date = date('Y-m-d H:i:s');

                $oldDir = './libraries/assets/article/temporary/';
                $dir = './libraries/assets/article/';
                $file = scandir($oldDir);

            
                if(isset($file['2'])){

                    $photoName = str_replace(" ", "_", $title);
                    $image_article = $dir.$photoName."-".$file['2'];
                    rename($oldDir.$file['2'], $image_article);
                    Tools::deleteInDir($oldDir);
                }
                if(isset($_FILES['articlePhoto'])){
                    if(!empty($_FILES['articlePhoto']['name'])){

                        $info = pathinfo($_FILES['articlePhoto']['type']);

                        $extension = array('jpg', 'jpeg', 'png', 'gif');

                        if(in_array($info['basename'], $extension)){
                            if($_FILES['articlePhoto']['size'] <= 2000000){

                                if(!is_null($image_article)){
                                    unlink($image_article);
                                    $image_article = null;
                                }
                                $photoName = str_replace(" ", "_", $title);

                                $image_article = "./libraries/assets/article/".$photoName."-".$_FILES['articlePhoto']['name'];
                                
                                $stock = move_uploaded_file($_FILES['articlePhoto']['tmp_name'], $image_article);
                                if(!$stock){
                                    $this->message = Tools::message("La photo n'a pas été envoyé");
                                }                            
                            }else{
                                $this->message = Tools::message("La taille de l'image ne doit pas dépasser 2Mo");
                            }
                        }else{
                            $this->message = Tools::message("Le fichier sélectionné n'est pas au bon format");
                        }
                    }
                }
                $this->model->insert($title, $content, $image_article, $date);

                $this->message = Tools::message("Article publié !", "success");

                header("refresh: 1; url=index.php");
            }else{
                $this->message = Tools::message("Veuillez remplir TOUS les champs !"); 
            } 
        }
    }

     
    /**
     * Prévisualisation de l'article avant sa creation
     * preview of articles before create
     *
     * @return void
     */
    public function preview(){
        if(isset($_POST['articleShow'])){
            $dir = 'libraries/assets/article/temporary/';
            $file = scandir($dir);
            if(isset($file['2'])){
                $photoPreview = $dir.$file['2'];
            }
            if(isset($_FILES['articlePhoto'])){
                if(!empty($_FILES['articlePhoto']['name'])){
        
                    $info = pathinfo($_FILES['articlePhoto']['type']);
        
                    $extension = array('jpg', 'jpeg', 'png', 'gif');
        
                    if(in_array($info['basename'], $extension)){
                        if($_FILES['articlePhoto']['size'] <= 2000000){
                            if(isset($photoPreview)){
                                Tools::deleteInDir($dir);
                                $photoPreview = null;
                            }
        
                                $photoPreview = $dir.$_FILES['articlePhoto']['name'];
                                
                                $stock = move_uploaded_file($_FILES['articlePhoto']['tmp_name'], $photoPreview);
        
                            if(!$stock){
                                $this->message = Tools::message("La photo n'a pas été envoyé");
                            }

                        }else{
                            $this->message = Tools::message("La taille de l'image ne doit pas dépasser 2Mo");
                        }

                    }else{
                        $this->message = Tools::message("Le fichier sélectionné n'est pas au bon format");
                    }
                }
            }
        }
        if(isset($photoPreview)){
            return $photoPreview;
        }
    }

}