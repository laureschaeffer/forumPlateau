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
            "meta_description" => "List of forum categories",
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

        //pour ne pas avoir d'erreur si un user tape dans la barre de recherche "id=100"
        if($category){
            return [
                "view" => VIEW_DIR."forum/listTopics.php",
                "meta_description" => "List of topics by category : ".$category,
                "data" => [
                    "category" => $category,
                    "topics" => $topics
                ]
            ];
        } else {
            $this->redirectTo("forum", "index"); exit; 
        }
    }


    //liste des posts en fonction d'un topic choisi (id)
    public function listPostsByTopic($id){

        //pour récupérer le nom du topic sur la page
        $topicManager = new TopicManager();
        $topics = $topicManager->findOneById($id);

        $postManager = new PostManager();
        $posts = $postManager->findPostsByTopic($id);

        //pour ne pas avoir d'erreur si un user tape dans la barre de recherche "id=100"
        if($topics){
            return [
                "view" => VIEW_DIR."forum/listPosts.php",
                "meta_description" => "List of posts by topic :" .$topics,
                "data" => [
                    "posts" => $posts,
                    "topics" => $topics
                ]
            ];
        } else {
            $this->redirectTo("forum", "index"); exit; 
        }

    }


    //detail d'un user et ses postes
    public function findOneUser($id){
        //infos generales
        $userManager = new UserManager();
        $userInfos = $userManager->findOneById($id);

        //posts ou user_id = ...
        $postManager = new PostManager();
        $postsUser = $postManager->findPostsByUser($id);

        //pour ne pas avoir d'erreur si l'user tape dans l'url id=100
        if($userInfos){
            return [
                "view" => VIEW_DIR."forum/userInfo.php",
                "meta_description" => "User informations",
                "data" => [
                    "userInfos" => $userInfos,
                    "postsUser" => $postsUser
                ]
            ];
        } else {
            $this->redirectTo("forum", "index"); exit;
        }

    }

    //formulaire ajout d'un topic avec ajout d'une publication sur ce topic, id de category
    public function addTopic($id){
        
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
                    Session::addFlash("success", "Topic well created");
                    $this->redirectTo("forum", "findPostsByTopic", $idTopic); exit;
    
                } else {
                    //ici message d'erreur 
                    Session::addFlash("error", "This topic already exist");
                    //redirection
                    $this->redirectTo("forum", "listTopicsByCategory", $id); exit;
                }
            }
        }
    }

    //formulaire d'ajout d'un post dans un topic déjà existant
    public function addPost($id){
        if(isset($_POST['submit'])){
            if(Session::getUser()){ //si l'utilisateur est toujours connecté
                //d'abord on filtre
                $texte= filter_input(INPUT_POST, "texte", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                if($texte){
                    $idUser = Session::getUser()->getId(); //id de l'user qui a créé le post
                    //tableau attendu en argument pour la fonction add
                    $data = ['texte' => $texte, 'topic_id' => $id, 'user_id'=>$idUser];
                    $postManager = new PostManager();
                    $postManager->add($data);

                    //quand tout est bon
                    Session::addFlash("success", "Post added");
                    $this->redirectTo("forum", "listPostsByTopic", $id); exit;
                }   
            } else {
                $this->redirectTo("security", "index"); exit;            
            }
        }
    }

    //ajout d'une categorie
    public function addCategory(){
        $this->restrictTo("ROLE_ADMIN"); 
        if(isset($_POST['submit'])){
            if(Session::getUser()) { // si l'utilisateur est toujours connectée
                //on filtre
                $name= filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
                //si tout est bon on l'ajoute
                if($name){
                    $categoryManager = new CategoryManager();
                    //tableau attendu en argument pour la fonction add
                    $dataPost = ['name' => $name];
        
                    $categoryManager->add($dataPost);
                }        
            } else {
                $this->redirectTo("security", "index"); exit;      
            }
        }

        Session::addFlash("success", "Category well created");
        $this->redirectTo("forum", "index"); exit;
    }
    
    // ------------------------------------------------------actions en fonctions des roles -------------------------------------

    //redirige vers le formulaire pour changer le nom d'un categorie: admin
    public function viewUpdateCategory($id){
        $this->restrictTo("ROLE_ADMIN");
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
        $this->restrictTo("ROLE_ADMIN");

        if(isset($_POST['submit'])){
            if(Session::getUser()){ //si l'utilisateur est toujours connecté
                //on filtre
                $name= filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
                //si tout est bon on l'ajoute dans la bdd
                if($name){
                    $categoryManager = new CategoryManager();
                    //tableau associatif colonne à modifier et sa valeur, pour "SET name='...' " dans le manager
                    $data =["name"=> "'".$name."'"]; //rajoute des quotes car 'name' attend un string dans la bdd
                    $categoryManager->update($data, $id);
                }
            } else {
                $this->redirectTo("security", "index"); exit;      
            }

        }
        Session::addFlash("success", "Category name updated");
        $this->redirectTo("forum", "index");

    }


    //supprimer un post : admin ou propriétaire
    public function deletePost($id){   
        $postManager = new PostManager();
        $post= $postManager->findOneById($id);
        
        if($post && Session::getUser()){ //verifie que le post existe et que l'utilisateur est toujours connecté

            //verifie que l'auteur du post existe encore, et si tu es l'auteur OU si tu es admin
            if(($post->getUser() && $post->getUser() == Session::getUser()) || Session::isAdmin()){
                $postManager->delete($id);
        
                Session::addFlash("success", "Post deleted");
                $this->redirectTo("forum", "index"); exit;

            } else {
                $this->redirectTo("forum", "index"); exit;        
            }
        }

    }

    //supprimer un topic: seulement admin
    public function deleteTopic($id){
        $this->restrictTo("ROLE_ADMIN"); 

        $topicManager = new TopicManager();
        $topic= $topicManager->findOneById($id);

        //si le topic existe et que l'utilisateur est connecté
        if($topic && Session::getUser()){
            $topicManager->delete($id);
    
            Session::addFlash("success", "Topic deleted");
            $this->redirectTo("forum", "index");
        } else {
            $this->redirectTo("forum", "index"); exit; 
        }
        

    }


    //verouille un topic : admin ou proprietaire
    public function lockTopic($id){
        $topicManager = new TopicManager();
        $topic= $topicManager->findOneById($id);

        if($topic && Session::getUser()){ //verifie que le topic existe et que l'utilisateur est connecté
            
            //verifie: si l'auteur du topic existe encore et si tu es l'auteur, OU si tu es admin
            if(($topic->getUser() && $topic->getUser() == Session::getUser()) || Session::isAdmin()){
                //tableau associatif colonne à modifier et sa valeur, pour "SET verouillage=1" dans le manager
                $data =["verouillage"=>1];
        
                //update attend les valeurs à modifier et l'id de l'endroit à modifier
                $topicManager->update($data, $id);
        
                Session::addFlash("success", "Topic locked");
                $this->redirectTo("forum", "listPostsByTopic", $id); exit; //redirige vers le lien qui montrent les post du topic

            } else {
                $this->redirectTo("forum", "index"); exit;
            }
        
        }
    }

    //deverouille un topic: admin ou proprietaire
    public function unlockTopic($id){
        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);

        if($topic && Session::getUser()){ //verifie si le topic existe et que l'utilisateur est connecté 

            //verifie : si l'auteur du topic existe encore, et si tu es l'auteur OU si tu es admin
            if(($topic->getUser() && $topic->getUser() == Session::getUser()) || Session::isAdmin()){

                //tableau associatif colonne à modifier et sa valeur, pour "SET verouillage=1" dans le manager
                $data =["verouillage"=>0];
        
                //update attend les valeurs à modifier et l'id de l'endroit à modifier
                $topicManager->update($data, $id);
        
                Session::addFlash("success", "Topic unlocked");
                $this->redirectTo("forum", "listPostsByTopic", $id); exit;

                
            } else {
                $this->redirectTo("forum", "index"); exit;
            }
        } else {
            $this->redirectTo("forum", "index"); exit;
        }

    }

    //redirige vers le formulaire de modif des posts qu'un utilisateur a créé
    public function viewUpdatePost($id){
        //post avec l'id du post
        $postManager = new PostManager();
        $posts = $postManager->findOneById($id);

        if($posts && Session::getUser()){ //si le post existe et si l'utilisateur est toujours connectée

            //verifie : si l'auteur du post existe encore et si tu en es l'auteur OU si tu es admin
            if(($posts->getUser() && $posts->getUser() == Session::getUser()) || Session::isAdmin()){

                return [
                    "view" => VIEW_DIR."update/modifPost.php",
                    "meta_description" => "Update your posts",
                    "data" => [
                        "posts" => $posts
                    ]
                ];

            } else {
                $this->redirectTo("forum", "index"); exit; 
            }
        } else {
            $this->redirectTo("forum", "index"); exit; 
        }

    }

    //change la valeur dans la bdd
    public function updatePost($id){
        if(isset($_POST['submit'])){
            $postManager = new PostManager();
            $posts = $postManager->findOneById($id);

            if($posts && Session::getUser()){ //si le post existe et si l'utilisateur est toujours connectée
                //verifie : si l'auteur du post existe encore et si tu en es l'auteur OU si tu es admin
                if(($posts->getUser() && $posts->getUser() == Session::getUser()) || Session::isAdmin()){
                    //on filtre
                    $texte= filter_input(INPUT_POST, "texte", FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                    
                    //si tout est bon on l'ajoute
                    if($texte){
                        //tableau associatif colonne à modifier et sa valeur, pour "SET texte= '..' " dans le manager
                        $data =["texte"=> "'".$texte."'"]; //rajoute des quotes car 'texte' attend un string dans la bdd
                        //update attend les valeurs à modifier et l'id de l'endroit à modifier
                        $postManager->update($data, $id);
                        
                        Session::addFlash("success", "Post updated");
                        //quand tout est fini on redirige vers la liste des post en fonction de l'id topic
                        $idTopic= self::viewUpdatePost($id)["data"]["posts"]->getTopic()->getId(); 
                        $this->redirectTo("forum", "listPostsByTopic", $idTopic); exit;
                    }

                } else {
                    $this->redirectTo("forum", "index"); exit;      
                }

            } else {
                $this->redirectTo("forum", "index"); exit;
            }    
        }
    }

    //redirige vers le formulaire de modification d'un topic
    public function viewUpdateTopic($id){
        $topicManager = new TopicManager();
        $topics = $topicManager->findOneById($id);

        if($topics && Session::getUser()){ //si le topic existe et si l'utilisateur est toujours connecté 

            //si l'auteur du topic existe et si tu en es l'auteur OU si tu es admin
            if(($topics->getUser() && $topics->getUser() == Session::getUser()) || Session::isAdmin()){
                
                return [
                    "view" => VIEW_DIR."update/modifTopic.php",
                    "meta_description" => "Update your topics",
                    "data" => [
                        "topics" => $topics
                    ]
                ];

            } else {
                $this->redirectTo("forum", "index"); exit;
            }
        
        } else {
            $this->redirectTo("forum", "index"); exit;
        }

    }

    //change la valeur dans la bdd
    public function updateTopic($id){
        if(isset($_POST['submit'])){
            $topicManager = new TopicManager();
            $topics = $topicManager->findOneById($id);

            if($topics && Session::getUser()){ //si le topic existe et si l'utilisateur est toujours connecté 

                //si l'auteur du topic existe et si tu en es l'auteur OU si tu es admin
                if(($topics->getUser() && $topics->getUser() == Session::getUser()) || Session::isAdmin()){
            
                    //on filtre
                    $titre= filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
                
                    //si tout est bon on l'ajoute
                    if($titre){            
                        //tableau associatif colonne à modifier et sa valeur, pour "SET titre='...' " dans le manager
                        $data =["titre"=> "'".$titre."'"]; //rajoute des quotes car 'titre' attend un string dans la bdd
                        $topicManager->update($data, $id);
                        //on redirige à la liste des topics en fonction de l'id de la categorie
                        Session::addFlash("success", "Topic name updated");
                        $idCat= self::viewUpdateTopic($id)["data"]["topics"]->getCategory()->getId();
                        $this->redirectTo("forum", "listTopicsByCategory", $idCat); exit;
                    }
                } else {
                    $this->redirectTo("forum", "index"); exit;     
                }
            }
        }
    }


}