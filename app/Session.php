<?php
namespace App;

class Session{

    private static $categories = ['error', 'success'];

    /**
    *   ajoute un message en session, dans la catégorie $categ
    */
    public static function addFlash($categ, $msg){
        $_SESSION[$categ] = $msg;
    }

    /**
    *   renvoie un message de la catégorie $categ, s'il y en a !
    */
    public static function getFlash($categ){
        
        if(isset($_SESSION[$categ])){
            $msg = $_SESSION[$categ];  
            unset($_SESSION[$categ]);
        }
        else $msg = "";
        
        return $msg;
    }

    /**
    *   met un user dans la session (pour le maintenir connecté)
    */
    public static function setUser($user){
        $_SESSION["user"] = $user;
    }

    public static function getUser(){
        return (isset($_SESSION['user'])) ? $_SESSION['user'] : false;
    }

    //verifie si l'utilisateur est admin
    public static function isAdmin(){
        // attention de bien définir la méthode "hasRole" dans l'entité User en fonction de la façon dont sont gérés les rôles en base de données
        if(self::getUser() && self::getUser()->hasRole("ROLE_ADMIN")){
            return true;
        }
        return false;
    }

    //verifie si l'utilisateur connecté est l'auteur d'un topic/post, place="topic" ou "post"
    // public static function isAuthor($place){
    //     if($place->getUser() && Session::getUser()->getId() == ){ //si on retrouve un user (sinon la fonction crée une erreur)
    //         return true; 
    //     } else {
    //         return false;
    //     }
    // }



}