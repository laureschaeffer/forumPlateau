<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;

class SecurityController extends AbstractController{
    // contiendra les méthodes liées à l'authentification : register, login et logout

    //rerigie vers créer un compte
    public function viewRegister () {
        
        return [
            "view" => VIEW_DIR."session/register.php",
            "meta_description" => "Create an account"
        ];
    }

    //créer un compte
    public function register () {
        $userManager = new UserManager;
        if($_POST["submit"]){

            //filtre les champs
            $email= filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_SPECIAL_CHARS);
            $pass1= filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_SPECIAL_CHARS);
            $pass2= filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_SPECIAL_CHARS);

            // si tout est bon
            if ($email && $pseudo && $pass1 && $pass2){

                
                //verifie que ni le pseudo ni le mail n'existe déjà dans la bdd ; renvoie un objet
                $userMail = $userManager->findOneByEmail($email);
                $userPseudo = $userManager->findOneByUser($pseudo);
                
                //renvoie true si existe
                if(!$userMail && !$userPseudo){

                    //verifier que les 2 mdp sont identiques et longueur>5 (12 recommandation de la cnil)
                    if($pass1 == $pass2 && strlen($pass1 >=12)){
                        //tableau attendu en argument pour la fonction add
                        $data = ['email' => $email, 'pseudo' => $pseudo, 'motdePasse' => password_hash($pass1, PASSWORD_DEFAULT)];
                        $userManager->add($data);
                    }

                }
                        

            } 
        }

        return [
            "view" => VIEW_DIR."home.php",
            "meta_description" => "Login"
        ];
    }

    //redirige vers la page de login
    public function viewLogin () {

        return [
            "view" => VIEW_DIR."session/login.php",
            "meta_description" => "Login"
        ];
    }

    //se connecte
    public function login () {
        $userManager = new UserManager;

        if($_POST["submit"]){
            //on filtre
            $email= filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $password= filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

            if ($email && $password){
                //cherche l'utilisateur

                //fonction qui cherche et verifie que l'utilisateur existe
                $user = $userManager->findOneByEmail($email);

                //si l'utilisateur existe
                if($user != NULL){
                    $hash = $user->getMotDePasse();
                    //si les empreintes numeriques correspondent
                    if(password_verify($password, $hash)){
                        $_SESSION["user"] = $user; //stocke tout l'utilisateur en session
                    } else{
                        $this->redirectTo("forum", "listCategories"); exit;
                    }
                } else {
                    $this->redirectTo("forum", "listPosts"); exit;
                }

            }

        }

        return [
            "view" => VIEW_DIR."home.php",
            "meta_description" => "Login"
        ];
    }


    public function logout () {}
}