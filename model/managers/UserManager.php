<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class UserManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\User";
    protected $tableName = "user";

    public function __construct(){
        parent::connect();
    }

    //nb posts d'un utilisateur, requete à part comme ça renvoie null s'il n'y a aucun post
    public function findNbPostsUser($id){
        $sql = "SELECT COUNT(t.id_topic) AS nbPost
        FROM topic t
        WHERE t.user_id= :id
        GROUP BY t.user_id
        ORDER BY nbPost DESC
        ";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['id' =>$id]), $this->className
        );
    }

    //verifie qu'un utilisateur existe en BDD selon son email
    public function findOneByEmail($email){
        $sql = "SELECT *
        FROM ".$this->tableName." a 
        WHERE a.email = :email";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['email' =>$email], false), $this->className
        );
    }
    
    public function findOneByUser($nickname){
        $sql = "SELECT *
        FROM ".$this->tableName." a 
        WHERE a.pseudo = :pseudo";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['pseudo' =>$nickname], false), $this->className
        );

    }

    //utilisateurs les plus actifs
    public function findTop3Users(){
        //selectionne toutes les infos d'un utilisateur et compte les topic d'un utilisateur, depuis la table topic
        $sql ="SELECT u.*, COUNT(t.id_topic) AS nbPost
        FROM topic t
        INNER JOIN user u ON t.user_id = u.id_user
        GROUP BY u.id_user
        ORDER BY nbPost DESC
        LIMIT 3";

        return $this->getMultipleResults(
            DAO::select($sql), 
            $this->className
        );
    }



}