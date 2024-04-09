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
        $sql = "SELECT   c.name, c.id_category , COUNT(t.id_topic) AS nbTopic
        FROM category c
        LEFT JOIN topic t ON c.id_category = t.category_id
        GROUP BY c.name, c.id_category" ;

        return $this->getMultipleResults(
            DAO::select($sql), 
            $this->className
        );
    }

    //cherche le titre d'une categorie, pour le formulaire d'ajout
    public function findCategoryTitle($name){
        $sql = "SELECT * FROM category c WHERE c.name = :name";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['name' => $name], false), $this->className
        );

    }

}