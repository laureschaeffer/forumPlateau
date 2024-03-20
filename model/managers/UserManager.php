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



}