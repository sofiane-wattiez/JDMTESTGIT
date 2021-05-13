<?php
namespace models;

class Comments extends Model
{
    protected $table = 'comments';
    protected $id = "id_comments";
    protected $col1  = "content";
    protected $col2  = "date";
    protected $col3  = "id_users";
    protected $col4  = "id_articles";

    /**
     * findInner
     *
     * @param  mixed $id
     * @param  mixed $order
     * @return array
     */
    public function findInner($id, string $order = null) :?array
    {
// Pour les join si le nom d'une colone et commune au deux table il faut mettre  table.colomn sinon erreurs
        $sql = "SELECT id_comments, content, date, id_articles, comments.id_users, pseudo FROM comments JOIN users ON comments.id_users = users.id_users WHERE id_articles = ?";
        if(!is_null($order)){
            $sql .= " ORDER BY " .$order;
        }
        $query = $this->pdo->prepare($sql);
        $query->execute([$id]);
        $result =   $query->fetchAll();

        if(false !== $result){
            return $result;
        }else{
            return null;
        }
    }
//     function insertComment($var1, $var2, $var3, $var4 , $var5) :void
//     {
//         $query = $this->pdo->prepare("INSERT INTO {$this->table} ({$this->col1}, {$this->col2}, {$this->col3}, {$this->col4}, {$this->col5) VALUES (?,?,?,?,?)");
//         $query->execute([$var1, $var2, $var3, $var4,$var5]);
//     }
 }