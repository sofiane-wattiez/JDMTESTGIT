<?php
namespace vue;
use \Tools;

class Comments extends Vue{
    
    /**
     * find
     *
     * @return void
     */
    public function find(){
        $this->commentController->insert();
        $comments = $this->commentController->findInner($_GET['id'], "date DESC");?>
        
        <div class="comment">
            <div class="commentTitle">
                <h1>Section Commentaire</h1>
                <?php if(isset($_SESSION['id_roles'])) :?>
                    <p>Il y a actuellement <?=count($comments)?> commentaire<?php Tools::pluralCount($comments) ?></p>
                    <?php if(count($comments) === 0) :?>
                        <p>Soyez le premier à réagir !</p>
                    <?php endif ?>
                <?php else :?>
                    <p>Veuillez vous connecter pour avoir accés à la section commentaire</p>
                <?php endif ?>
            </div>
            <?php if(isset($_SESSION['id_roles'])) :
                $this->insert();
                if(count($comments) > 0) :?>
                    <div class="commentResult">
                        <?php foreach($comments as $comment) :?>
                            <div class="commentSolo">
                                <div class="commentPseudo">
                                    <p><b><?= $comment['pseudo'] ?></b></p>
                                </div>
                                <div class="commentContent">
                                    <p><?= $comment['content'] ?></p>
                                </div>
                                <div class="commentDate">
                                    <span class="date"><i>Commentaire fait le <?= $comment['date'] ?></i></span>
                                </div>
                                <?php if($comment['pseudo'] === $_SESSION['pseudo'] || $_SESSION['id_roles'] === '1' || $_SESSION['id_roles'] === '2') :?>
                                    <div class='commentDelete'>
                                        <a href="index.php?delete=delete_comment&id_comments=<?=$comment['id_comments']?>&id_users=<?=$comment['id_users']?>&id_articles=<?=$comment['id_articles']?>" onclick="return window.confirm(`Êtes-vous sûr ?`)">Supprimer commentaire</a>
                                    </div>
                                <?php endif?>
                            </div>
                        <?php endforeach?>
                    </div>
                <?php endif?>
            <?php endif?>
        </div>
        <?php
    }

    /**
     * insert
     *
     * @return void
     */
    public function insert(){
        ?>
        <div class="commentForm">
            <form action="" method="post">
                <textarea name="commentText" rows="5" placeholder="Commentaire..."></textarea>
                <p><?= $this->commentController->message ?></p>
                <input type="submit" name="commentSubmit" class="btn btn-primary">
            </form>
        </div><?php
    }
}