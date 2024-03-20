<?php
namespace Controller;

use App\Session;
use App\DAO;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use Model\Managers\UserManager;


class ForumController extends AbstractController implements ControllerInterface{

    //donne la liste des categories
    public function index() {
        
        // créer une nouvelle instance de CategoryManager
        $categoryManager = new CategoryManager();
        // récupérer la liste de toutes les catégories grâce à la méthode findAll de Manager.php (triés par nom)
        $categories = $categoryManager->findAll(["name", "ASC"]);

        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
        return [
            "view" => VIEW_DIR."forum/listCategories.php",
            "meta_description" => "Liste des catégories du forum",
            "data" => [
                "categories" => $categories
            ]
        ];
    }


    //liste des sujets en fonction d'une catégorie
    public function listTopicsByCategory($id) {

        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);
        $topics = $topicManager->findTopicsByCategory($id);

        return [
            "view" => VIEW_DIR."forum/listTopics.php",
            "meta_description" => "Liste des topics par catégorie : ".$category,
            "data" => [
                "category" => $category,
                "topics" => $topics
            ]
        ];
    }


    //liste des posts en fonction du sujet choisi (id)
    public function listPostsByTopic($id){

        $postManager = new PostManager();

        $posts = $postManager->findPostsByTopic($id);

        return [
            "view" => VIEW_DIR."forum/listPosts.php",
            "meta_description" => "Liste des postes du topic",
            "data" => [
                "posts" => $posts
            ]
        ];
    }

    //liste de tous les users
    public function listUsers(){

        $userManager = new UserManager();

        $users = $userManager->findAll(["dateInscription", "ASC"]);

        return [
            "view" => VIEW_DIR."forum/listUsers.php",
            "meta_description" => "Liste des inscrits au forum",
            "data" => [
                "users" => $users
            ]
        ];
    }

    //detail d'un user et ses postes
    public function findOneUser($id){
        //infos generales
        $userManager = new UserManager();
        $userInfos = $userManager->findOneById($id);

        //posts ou user_id = ...
        $postManager = new PostManager();
        $postsUser = $postManager->findPostsByUser($id);

        return [
            "view" => VIEW_DIR."forum/userInfo.php",
            "meta_description" => "Detail d'un utilisateur",
            "data" => [
                "userInfos" => $userInfos,
                "postsUser" => $postsUser
            ]
        ];
    }





}