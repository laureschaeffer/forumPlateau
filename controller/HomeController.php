<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;
use Model\Managers\PostManager;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;


class HomeController extends AbstractController implements ControllerInterface {

    public function index(){
        return [
            "view" => VIEW_DIR."home.php",
            "meta_description" => "Page d'accueil du forum"
        ];
    }
        
    //tous les user, accessibles seulement aux admins
    public function listUsers(){
        $this->restrictTo("ROLE_ADMIN");

        $manager = new UserManager();
        $users = $manager->findAll(['dateInscription', 'DESC']);

        return [
            "view" => VIEW_DIR."forum/listUsers.php",
            "meta_description" => "Liste des utilisateurs du forum",
            "data" => [ 
                "users" => $users 
            ]
        ];
    }

    //profil de la personne, à récupérer dans session
    public function profil(){
        $id = Session::getUser()->getId();

        //infos generales
        $userManager = new UserManager();
        $userInfos = $userManager->findOneById($id);

        //posts
        $postManager = new PostManager();
        $postsUser = $postManager->findPostsByUser($id);

        //topics créés
        $topicManager = new TopicManager();
        $topicsUser = $topicManager->findTopicsUser($id);

        return [
            "view" => VIEW_DIR."forum/profil.php",
            "meta_description" => "Your profil",
            "data" => [
                "userInfos" => $userInfos,
                "postsUser" => $postsUser,
                "topicsUser" => $topicsUser
            ]
        ];
    }

    
}
