<?php 
namespace vue;
use controllers\Security;
use \Tools;
use \vue\Comments;
// use controllers\Article;


class Article  extends Vue {

    // protected $id = 'id';
    private $commentVue;

    public function __construct()
    {
        parent::__construct();
        $this->commentVue = new Comments();
    }

    public function findAll(){

        if(isset($_GET["delete"])){
            if($_GET['delete']      === 'delete_article'){
                $this->articleController->delete();
            }elseif($_GET['delete'] === 'delete_comment'){
            $this->commentController->delete();
            }elseif($_GET['delete'] === 'delete_from_list'){
                $this->userController->delete();
            }
        }
        // var_dump($_SESSION);
        $articles = $this->articleController->findAll("date DESC");
        foreach ($articles as $article) :?>
            <div class="containerArticle">
                <div class="article">
                    <?php if($article['image_article'] != null) :?>
                        <div class="articlePhoto" >
                            <img src="<?=$article['image_article']?>">
                        </div>
                    <?php endif ?>
                        <div class="articleTitle">
                            <h1><?=$article['nom_produits']?></h1>
                            <span class="date"><i>Article créé le <?=$article['date']?></i></span>
                        </div>
                    <?php if($article['image_article'] != null) :?>
                        <div class="articleContent min">
                    <?php else :?>
                        <div class="articleContent max">
                    <?php endif ?>
                            <p><?=$article['content']?></p>
                        </div>
                        <!-- <div class="articleButton">
                        <a href="index.php?vue=Article&task=find&id=<?=$article['id_articles']?>"><button class="articleBtn btn btn-primary">Lire la suite</button></a>
                        </div> -->
                        <div class="articleButton2">
                        <a href="index.php?vue=Article&task=find&id=<?=$article['id_articles']?>"><button class="articleBtn btn btn-primary">Commentaires</button></a>
                        </div>
                        <div class="articleButton3">
                        <a href="index.php?vue=Article&task=find&id=<?=$article['id_articles']?>"><button class="articleBtn btn btn-primary">Partager</button></a>
                        </div>
                    </div>
                    <?php if(isset($_SESSION['id_roles']) && $_SESSION['id_roles'] == 1 OR isset($_SESSION['id_roles']) AND $_SESSION['id_roles'] == 2 ) :?>
                        <div class="articleShowUpdate">
                            <a href="index.php?vue=Article&task=update&id=<?=$article['id_articles']?>">Modifier</a>
                        </div>
                        <div class="articleDelete">
                            <a href="index.php?id=<?=$article['id_articles']?>&delete=delete_article<?=Tools::photoGet($article)?>" onclick="return window.confirm(`Êtes-vous sûr de supprimer l'article?`)">Supprimer</a>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        <?php endforeach;
    }

      /**
     * find
     *
     * @return void
     */
    
    public function find(){
        $this->articleController->delete();
        $articleSolo = $this->articleController->find($_GET['id']);
        ?>
        <div class="articleSolo">
            <?php if($articleSolo['image_article'] != null) :?>
                <div class="articleSoloPhoto">
                    <img src="<?=$articleSolo['image_article']?>">
                </div>
            <?php endif?>
            <div class="articleSoloTitle">
                <h1><?=$articleSolo['nom_produits']?></h1>
                <span class="date"><i>Article créé le <?=$articleSolo['date']?></i></span>
            </div>
            <div class="articleSoloContent">
                <p><?=$articleSolo['content']?></p>
            </div>

            <?php if(isset($_SESSION['id_roles']) && $_SESSION['id_roles'] == 1 OR isset($_SESSION['id_roles']) AND $_SESSION['id_roles'] == 2 ) :?>

                <div class="articleSoloLink">
                    <div class="articleSoloUpdate">
                        <a href="index.php?id=<?=$articleSolo['id_articles']?>&vue=Article&task=update">Modifier l'article</a>
                    </div>
                    <div class="articleSoloDelete">
                        <a href="index.php?id=<?=$articleSolo['id_articles']?>&delete=delete_article<?=Tools::photoGet($articleSolo)?>" onclick="return window.confirm(`Êtes-vous sûr ?`)">Supprimer l'article</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php $this->commentVue->find();
    }


    public function insert(){
        $photoPreview = $this->articleController->preview();
        $this->articleController->insert();
        ?>
        <div class="articleCreate">
            <div class="articleCreateTitle">
                <h1>Création d'article</h1>
            </div>
            <div class="articleCreateForm">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="articleCreateTextarea">
                        <span>Titre</span>
                        <textarea name="articleTitle" id="" cols="100" rows="1"><?php Tools::sendInput("articleTitle") ?></textarea>
                        <span>Contenu</span>
                        <textarea name="articleContent" id="" cols="100" rows="8"><?php Tools::sendInput("articleContent") ?></textarea>
                    </div>
                    <div class="articleCreatePhoto">
                        <label for="articleFile" class="btn btn-light articlePhotoAdd">Ajouter une photo</label>
                        <input type="file" id="articleFile" name="articlePhoto">
                        <input type="submit" name="deletePhoto" class="btn btn-danger articlePhotoDel" value="Supprimer photo">
                    </div>
                    <div class="articleCreateMessage">
                        <?= $this->articleController->message ?>
                    </div>
                    <div class="articleSubmitButton">
                        <input class="btn btn-primary articleSubmit" type="submit" name="articleSubmit" value="Poster">
                        <input class="btn btn-primary articleShow" type="submit" name="articleShow" value="Aperçu">
                    </div>    
                </form>
            </div>
        </div>
        <?php if(isset($_POST['articleShow'])) :?>
            <div class="preview">
                <h1>Aperçu</h1>
            </div>
            <div class="articlePreview">
                <?php if(!is_null($photoPreview)) :?>
                    <div class="articlePreviewPhoto">
                        <img src="<?= $photoPreview ?>">
                    </div>
                <?php endif ?>
                <div class="articlePreviewTitle">
                    <h1><?php Tools::sendInput("articleTitle") ?></h1>
                </div>
                <div class="articlePreviewContent">
                    <p><?php Tools::sendInput("articleContent") ?></p>
                </div>
            </div>
        <?php endif;
    }

        public function update(){
            $articleSolo = $this->articleController->update($_GET['id']);
            // var_dump($_GET);
            ?>
            <div class="articleUpdateHeader">
                <h1>Modification d'article</h1>
                <p><?= $this->articleController->message?></p>
            </div>
            <div class="articleUpdate">
                <div class="articleUpdateForm">
                    <?php if(isset($articleSolo['image_article']))  :?>
                        <div class="articleUpdatePhoto">
                            <img src="<?=$articleSolo['image_article']?>">
                        </div>
                    <?php endif ?>
                    <form action="" enctype="multipart/form-data" method="POST">
                        <div class="articleUpdateTitle">
                            <span>Titre</span>
                            <textarea name="articleUpdateTitle" rows="1"><?=$articleSolo['nom_produits']?></textarea>
                        </div>
                        <div class="articleUpdateContent">
                            <span>Contenu</span>
                            <textarea name="articleUpdateContent" rows="10"><?=$articleSolo['content']?></textarea>
                        </div>
                        <div class="articleUpdateFileButton">
                            <label for="articleUpdateFile" class="articleUpdateFile btn btn-light">Choisir une photo</label>
                            <input type="file" name="articleUpdateFile" class="none" id="articleUpdateFile">
                            <input type="submit" name="articleUpdatePhotoDel" class="articleUpdatePhotoDel" value="Supprimer la photo">
                        </div>
                        <div class="articleUpdateSubmitButton">
                            <input type="submit" name="articleUpdateSubmit" class="articleUpdateSubmit btn btn-primary" value="Modifier l'article">
                        </div>
                    </form>
                </div>
            </div><?php
        }


}
