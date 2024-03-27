<?php
namespace Model\Entities;

use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class User extends Entity{

    private $id;
    private $email;
    private $pseudo;
    private $motDePasse;
    private $dateInscription;
    private $role;

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


    public function getEmail()
    {
        return $this->email;
    }


    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }


    public function getPseudo()
    {
        return $this->pseudo;
    }


    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

  
    public function getMotDePasse()
    {
        return $this->motDePasse;
    }


    public function setMotDePasse($motDePasse)
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

 
    public function getDateInscription()
    {
        return $this->dateInscription;
    }


    public function setDateInscription($dateInscription)
    {
        $this->dateInscription = new \DateTime($dateInscription);

        return $this;
    }


    public function getRole()
    {
        return $this->role;
    }


    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    
    public function __toString() {
        return $this->pseudo;
    }

    //verifie le role des user
    public function hasRole($role){
        if ($this->getRole() == $role) {
            return true;
        } else {
            return false;
        }
    }

    //donne le role, pour les admin
    public function getRoleUser(){
        $roles = explode("_", $this->role);
        return strtolower($roles[1]);
    }
}