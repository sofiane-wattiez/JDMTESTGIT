<?php
namespace controllers;
use \Tools;

class Comments extends Controller{

    public function __construct(){
        $this->model    = new \models\Comments();
        $this->message      = Tools::message("message", "light not");
    }
    
    /**
     * findInner
     *
     * @param  mixed $id
     * @param  mixed $order
     * @return array
     */
    public function findInner($id, $order){
        $comments = $this->model->findInner($id, $order);
        return $comments;
    }
    
    /**
     * insert
     *
     * @return void
     */
    public function insert(){
        if(isset($_POST['commentSubmit'])){
            if(!empty($_POST['commentText'])){
                $content = Tools::safe_input($_POST['commentText']);
                $date = date('Y-m-d H:i:s');

                $this->model->insert($content, $date, $_SESSION['id_users'], $_GET['id']);

            }else{
                $this->message = Tools::message("Veuillez remplir la zone commentaire");
            }
        }
    }
}