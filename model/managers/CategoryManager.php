<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class CategoryManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Category";
    protected $tableName = "category";

    public function __construct(){
        parent::connect();
    }

    //calcule le nb de topics d'une categorie
    public function listCategories(){
        $sql = "SELECT COUNT(t.id_topic) as nbTopic, c.*
        FROM topic t
        INNER JOIN category c on t.category_id = c.id_category
        GROUP BY t.category_id
        ORDER BY c.name" ;

        return $this->getMultipleResults(
            DAO::select($sql), 
            $this->className
        );
    }

}