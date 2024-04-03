<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class TopicManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Topic";
    protected $tableName = "topic";

    //le parent ("App/Manager") a une fonction connect(), elle-même reliée au DAO pour se connecter
    public function __construct(){
        parent::connect();
    }

    // récupérer tous les topics d'une catégorie spécifique (par son id)
    public function findTopicsByCategory($id) {

        $sql = "SELECT * 
                FROM ".$this->tableName." t 
                WHERE t.category_id = :id
                ORDER BY t.dateCreation DESC";
       
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );
    }

    //cherche le titre d'un topic, pour le formulaire d'ajout
    public function findTopicTitle($titre){
        $sql = "SELECT * FROM topic t WHERE t.titre = :titre";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['titre' => $titre], false), $this->className
        );

    }

    //topic par utilisateur
    public function findTopicsUser($id){
        $sql = "SELECT * from ".$this->tableName." a
        WHERE a.user_id = :id";

        return $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]),
            $this->className
        );
    }

    //trouve les 3 topics qui contiennent le plus de post
    public function findTop3Topics(){
        //selectionne toutes les infos d'un topic et compte les posts d'un topic, depuis la table post
        $sql = "SELECT t.* , COUNT(p.id_post) AS nbPost
        FROM TOPIC t
        INNER JOIN POST p ON t.id_topic = p.topic_id
        GROUP BY t.id_topic
        ORDER BY nbPost DESC
        LIMIT 3" ;

        return $this->getMultipleResults(
            DAO::select($sql), 
            $this->className
        );
    }

}