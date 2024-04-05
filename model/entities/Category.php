<?php
namespace Model\Entities;

use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class Category extends Entity{

    private $id;
    private $name;
    private $nbTopic; //recupere le count dans la requete du manager, cette colonne n'existe pas dans la bdd

    // chaque entité aura le même constructeur grâce à la méthode hydrate (issue de App\Entity)
    public function __construct($data){         
        $this->hydrate($data);        
    }


    public function getId()
    {
        return $this->id;
    }


    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getName(){
        return $this->name;
    }


    public function setName($name){
        $this->name = $name;
        return $this;
    }

    public function getNbTopic(){
        return $this->nbTopic;
    }


    public function setNbTopic($nbTopic){
        $this->nbTopic = $nbTopic;
        return $this;
    }

    public function __toString(){
        return $this->name;
    }
}