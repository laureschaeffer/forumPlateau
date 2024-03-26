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
                    $idUser = Session::getUser()->getId(); //id de l'user
                    //tableau attendu en argument pour la fonction add
                    $dataTopic = ['titre' => $titre, 'category_id' => $id, 'user_id'=>$idUser];
    
                    //recupere id du topic
                    $idTopic= $topicManager->add($dataTopic);
    
                    //ajoute post
                    $postManager = new PostManager();

                    //tableau attendu en argument pour la fonction add
                    $dataPost = ['texte' => $texte, 'user_id' => $idUser, 'topic_id' =>$idTopic];
    
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

    //ajout d'une categorie
    public function addCategory(){
        if(isset($_POST['submit'])){
            //on filtre
            $name= filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //si tout est bon on l'ajoute
            if($name){
                $categoryManager = new CategoryManager();
                //tableau attendu en argument pour la fonction add
                $dataPost = ['name' => $name];
    
                $categoryManager->add($dataPost);
            }
        }

        $this->redirectTo("forum", "index"); exit;
    }
    
    // ------------------------------------------------------actions en fonctions des roles -------------------------------------

    //redirige vers le formulaire pour changer le nom d'un categorie: admin
    public function viewUpdateCategory($id){
        $categoryManager = new CategoryManager();

        $categories = $categoryManager->findOneById($id);

        return [
            "view" => VIEW_DIR."update/modifCategory.php",
            "meta_description" => "Update a category name",
            "data" => [
                "categories" => $categories
            ]
        ];
    }

    //change le nom en bdd
    public function updateCategory($id){

        if(isset($_POST['submit'])){
            //on filtre
            $name= filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //si tout est bon on l'ajoute dans la bdd
            if($name){
                $categoryManager = new CategoryManager();
                //tableau associatif colonne à modifier et sa valeur, pour "SET name='...' " dans le manager
                $data =["name"=> "'".$name."'"]; //rajoute des quotes car 'name' attend un string dans la bdd
                $categoryManager->update($data, $id);
            }

        }

        $this->redirectTo("forum", "index");

    }


    //supprimer un post : admin ou propriétaire
    public function deletePost($id){        
        $postManager = new PostManager();
        $postManager->delete($id);

        $this->redirectTo("forum", "index"); exit;
    }


    //verouille un topic : admin ou proprietaire
    public function lockTopic($id){
        $topicManager = new TopicManager();
        //tableau associatif colonne à modifier et sa valeur, pour "SET verouillage=1" dans le manager
        $data =["verouillage"=>1];

        //update attend les valeurs à modifier et l'id de l'endroit à modifier
        $topicManager->update($data, $id);

        $this->redirectTo("forum", "index"); exit;
    }

    //deverouille un topic: admin ou proprietaire
    public function unlockTopic($id){
        $topicManager = new TopicManager();
        //tableau associatif colonne à modifier et sa valeur, pour "SET verouillage=1" dans le manager
        $data =["verouillage"=>0];

        //update attend les valeurs à modifier et l'id de l'endroit à modifier
        $topicManager->update($data, $id);

        $this->redirectTo("forum", "index"); exit;
    }

    //redirige vers le formulaire de modif des posts qu'un utilisateur a créé
    public function viewUpdatePost($id){
        //post avec l'id du post
        $postManager = new PostManager();
        $posts = $postManager->findOneById($id);

        return [
            "view" => VIEW_DIR."update/modifPost.php",
            "meta_description" => "Update your posts",
            "data" => [
                "posts" => $posts
            ]
        ];
    }

    //change la valeur dans la bdd
    public function updatePost($id){
        if(isset($_POST['submit'])){
            //on filtre
            $texte= filter_input(INPUT_POST, "texte", FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            
            //si tout est bon on l'ajoute
            if($texte){
                $postManager = new PostManager();
                //tableau associatif colonne à modifier et sa valeur, pour "SET texte= '..' " dans le manager
                $data =["texte"=> "'".$texte."'"]; //rajoute des quotes car 'texte' attend un string dans la bdd
                //update attend les valeurs à modifier et l'id de l'endroit à modifier
                $postManager->update($data, $id);

            }
        
        }

        //quand tout est fini on redirige
        $this->redirectTo("home", "profil"); exit;
    }

    //redirige vers le formulaire de modification d'un topic
    public function viewUpdateTopic($id){
        $topicManager = new TopicManager();
        $topics = $topicManager->findOneById($id);

        return [
            "view" => VIEW_DIR."update/modifTopic.php",
            "meta_description" => "Update your topics",
            "data" => [
                "topics" => $topics
            ]
        ];
    }

    //change la valeur dans la bdd
    public function updateTopic($id){

        if(isset($_POST['submit'])){
            //on filtre
            $titre= filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
            
            //si tout est bon on l'ajoute
            if($titre){
                $topicManager = new TopicManager();
        
                //tableau associatif colonne à modifier et sa valeur, pour "SET titre='...' " dans le manager
                $data =["titre"=> "'".$titre."'"]; //rajoute des quotes car 'titre' attend un string dans la bdd
                $topicManager->update($data, $id);
            }
        }

        //on redirige quand tout est fini
        $this->redirectTo("home", "profil"); exit;
    }


}