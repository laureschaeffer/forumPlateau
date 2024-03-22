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


    //liste des topics en fonction d'une catégorie
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


    //liste des posts en fonction d'un topic choisi (id)
    public function listPostsByTopic($id){

        //pour récupérer le nom du topic sur la page
        $topicManager = new TopicManager();
        $topics = $topicManager->findOneById($id);

        $postManager = new PostManager();

        $posts = $postManager->findPostsByTopic($id);

        return [
            "view" => VIEW_DIR."forum/listPosts.php",
            "meta_description" => "Liste des postes du topic",
            "data" => [
                "posts" => $posts,
                "topics" => $topics
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

    //formulaire ajout d'un topic avec ajout d'une publication sur ce topic, id de category
    public function formTopic($id){
        
        // dabord on filtre 
        if(isset($_POST['submit'])){
            $titre= filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS); //dans topic

            $texte= filter_input(INPUT_POST, "texte", FILTER_SANITIZE_FULL_SPECIAL_CHARS); //dans post

            
            // pour l'instant sur id d'un user fixe
            if ($titre && $texte){

                // verifie que le titre du topic n'existe pas déjà 
                $topicManager = new TopicManager();
                $titreTopicBDD = $topicManager->findTopicTitle($titre);
    
                //renvoie true si le titre existe
                if(!$titreTopicBDD){
                    //ajout topic
                    //tableau attendu en argument pour la fonction add
                    $dataTopic = ['titre' => $titre, 'category_id' => $id, 'user_id'=>3];
    
                    //recupere id du topic
                    $idTopic= $topicManager->add($dataTopic);
    
                    //ajoute post
                    $postManager = new PostManager();
                    //tableau attendu en argument pour la fonction add
                    $dataPost = ['texte' => $texte, 'user_id' => 3, 'topic_id' =>$idTopic];
    
                    $postManager->add($dataPost);
    
                    //si tout est bon
                    $this->redirectTo("forum", "findPostsByTopic", $idTopic); exit;
    
                } else {
                    //ici message d'erreur 

                    //redirection
                    $this->redirectTo("forum", "listTopicsByCategory", $id); exit;
                }
            }
        }
    }
    
    // ------------------------------------------------------actions en fonctions des roles -------------------------------------

    //supprimer la categorie
    public function deleteCategory($id){
        // $this->restrictTo("ROLE_ADMIN");
        
        $categoryManager = new CategoryManager();
        $categoryManager->delete($id);

        $this->redirectTo("forum", "index"); exit;
    }

    //modifier le nom d'une categorie
    // public function changeCategory($id){
    //     $categoryManager = new CategoryManager();

    //     //recupere le nom ici
    //     $data=[""];
    //     //execute
    //     $categoryManager->update($data, $id);
    // }

    //verouille un topic
    public function lockTopic($id){
        $topicManager = new TopicManager();
        //pour "SET verouillage=1" dans le manager
        $values = ["verouillage = 1"];

        //update attend les valeurs à modifier et l'id de l'endroit à modifier
        $topicManager->update($values, $id);

        // $this->redirectTo("forum", "index"); exit;

    }


}