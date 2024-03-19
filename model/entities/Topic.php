<?php
namespace Model\Entities;

use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class Topic extends Entity{

    private $id;
    private $titre;
    private $dateCreation;
    private $verouillage;
    private $categorie;
    private $user;

    public function __construct($data){         
        $this->hydrate($data);        
    }


    public function getId(){
        return $this->id;
    }


    public function setId($id){
        $this->id = $id;
        return $this;
    }

 
    public function gettitre(){
        return $this->titre;
    }


    public function settitre($titre){
        $this->titre = $titre;
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


    public function getVerouillage()
    {
        return $this->verouillage;
    }


    public function setVerouillage($verouillage)
    {
        $this->verouillage = $verouillage;

        return $this;
    }


    public function getCategorie()
    {
        return $this->categorie;
    }


    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

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

    public function __toString(){
        return $this->titre;
    }

}