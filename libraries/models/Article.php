<?php

namespace models;

class Article extends Model {

    protected $table = "articles";
    protected $id  = "id_articles";
    protected $col1  = "nom_produits";
    protected $col2  = "content";
    protected $col3  = "image_article";
    protected $col4  = "date";
  
    
    
    /**
     * Mise a jours des données / update  for data's by table articles
     *
     * @param  mixed $title
     * @param  mixed $content
     * @param  mixed $avatar
     * @param  mixed $date
     * @param  mixed $id
     * @return bool
     */
    function update(string $title, string $content, ?string $image_article, $col4, $id) :bool
    {
        $update = $this->pdo->prepare("UPDATE {$this->table} SET {$this->col1} = ?, {$this->col2} = ?, {$this->col3} = ?, {$this->col4} = ? WHERE {$this->id} = ?");
        $update->execute([$title, $content, $image_article, $col4, $id]);

        return true;
    }
    
    /**
     * Mise a jours de une seul col dans la table articles / updateOne data on table articles
     *
     * @param  mixed $col
     * @param  mixed $id
     * @param  mixed $what
     * @return bool
     */
    function updateOne(string $col, $id, $what = null) :bool
    {
        $update = $this->pdo->prepare("UPDATE {$this->table} SET {$col} = ? WHERE {$this->id} = ?");
        $update->execute([$what, $id]);

        return true;
    }
}
?>