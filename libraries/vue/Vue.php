<?php
namespace vue;


use \controllers\Article;
use \controllers\Comments;
use \controllers\Users;

abstract class Vue{

    protected $articleController;
    protected $commentController;
    protected $userController;

    public function __construct(){
        $this->articleController = new Article();
        $this->commentController = new Comments();
        $this->userController = new Users();
    }
}