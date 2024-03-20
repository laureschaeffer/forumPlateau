<?php
namespace Model\Entities;

use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class Post extends Entity{

    private $id;
    private $texte;
    private $dateCreation;
    private $user; //c'est un objet
    private $topic; //objet

    public function __construct($data){         
        $this->hydrate($data);        
    }




    public function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;

        return $this;
    }


    public function getTexte()
    {
        return $this->texte;
    }


    public function setTexte($texte)
    {
        $this->texte = $texte;

        return $this;
    }


    public function getDateCreation()
    {
        return $this->dateCreation;
    }


    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }


    public function getUser()
    {
        return $this->user;
    }


    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }


    public function getTopic()
    {
        return $this->topic;
    }


    public function setTopic($topic)
    {
        $this->topic = $topic;

        return $this;
    }

    
    public function __toString(){
        return $this->texte;
    }

}