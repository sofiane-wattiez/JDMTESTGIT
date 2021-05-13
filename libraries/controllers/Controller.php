<?php 
namespace controllers;
use \Tools;

abstract class Controller {

    protected $model;
    protected $modelName;
    protected $articleController;
    protected $userController;
    public    $message;
    public    $messagePass;

    public function __construct(){

        $this->model = new $this->modelName;
        $this->message      = Tools::message("message", "light not");
        $this->messagePass      = Tools::message("message", "light not");

    }

    /**
     * delete
     *
     * @return void
     */
    public function delete(){
        if(isset($_GET['delete'])){

            $getDelete = Tools::safe_input($_GET["delete"]);

            if($getDelete === 'delete_user'){

                \controllers\Security::session();
                if($_SESSION['avatar'] !== './libraries/assets/users_photo/avatar.jpg'){
                    unlink($_SESSION['avatar']);
                }

                $this->model->delete($_SESSION['id_users']);
                header("Location:index.php?disconnect");

            }elseif($getDelete === 'delete_from_list'){

                \controllers\Security::admin();

                if($_GET['id'] !== $_SESSION['id_users']){

                    if($_GET['avatar'] !== './libraries/assets/users_photo/avatar.jpg'){
                        unlink('../'.$_GET['avatar']);
                    }

                    $this->model->delete(Tools::safe_input($_GET['id']));
                    header("Location: index.php?vue=Users&task=findAll");

                }else{
                    header("Location: index.php?vue=Users&task=findAll");
                }
            }elseif($getDelete === 'delete_article'){

                \controllers\Security::admin();

                if(isset($_GET['image_article'])){
                    unlink($_GET['image_article']);
                }

                $this->model->delete(Tools::safe_input($_GET['id']));

                header("Location: index.php");

            }elseif($getDelete === 'delete_comment'){

                \controllers\Security::session();

                $getIdArticles = Tools::safe_input($_GET["id_articles"]);

                if($_SESSION['id_roles'] == '1'){

                    $this->model->delete(Tools::safe_input($_GET['id_comments']));
                    header("Location:index.php?vue=Article&task=find&id=".$getIdArticles);

                }elseif($_GET['id'] === $_SESSION['id']){

                    $this->model->delete(Tools::safe_input($_GET['id_comments']));
                    header("Location:index.php?vue=Article&task=find&id=".$getIdArticles);

                }
            }else{
                header("Location:index.php");
            }
        }
    }
}
?>