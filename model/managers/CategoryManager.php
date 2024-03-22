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

    //modifier une categorie
    public function changeCategoryBDD($name, $id){
        $sql= "UPDATE ".$this->tableName. "
        SET NAME = :name
        WHERE id_category= :id";

        $sql->execute(["name"=>$name ,"id"=>$id]);
    }
}