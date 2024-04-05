<?php
namespace Controller;

use App\Session;
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
        if(isset($_POST["submit"])){

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
                    // Valide la qualité du mdp
                    $uppercase = preg_match('@[A-Z]@', $pass1); //une majuscule
                    $lowercase = preg_match('@[a-z]@', $pass1); //une minuscule
                    $number    = preg_match('@[0-9]@', $pass1); //un nombre
                    $specialChars = preg_match('@[^\w]@', $pass1); //un caractere special

                    //si ces conditions ne sont pas remplies
                    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($pass1) < 11) {
                        Session::addFlash("error", "Password should be at least 12 characters in length and should include at least one upper case letter, one number, and one special character");
                        $this->redirectTo("security", "viewRegister"); exit; 
                    } else { //si le mdp valide on verifie que les 2 mdp correspondent
                        if($pass1 == $pass2){
                            //tableau attendu en argument pour la fonction add
                            $data = ['email' => $email, 'pseudo' => $pseudo, 'motdePasse' => password_hash($pass1, PASSWORD_DEFAULT)];
                            $userManager->add($data);

                            //ensuite cherche l'utilisateur créé dans la bdd
                            $user = $userManager->findOneByEmail($email);
                            $_SESSION["user"] = $user; //stocke tout l'utilisateur en session
                            $this->redirectTo("forum", "index"); exit;
                        } else {
                            Session::addFlash("error", "Passwords don't match");
                            $this->redirectTo("security", "viewRegister"); exit ;
                        }
                    }
                    //si le mail ou le pseudo existe déjà en bdd
                } else {
                    //ne pas etre trop précis pour ne pas donner trop d'informations à des utilisateurs malveillants
                    Session::addFlash("error", "Nickname or email already existing");
                    $this->redirectTo("security", "viewRegister"); exit; 
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

        if(isset($_POST['submit'])){
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
                        //ne pas etre trop précis pour ne pas donner trop d'informations à des utilisateurs malveillants
                        Session::addFlash("error", "Invalid credentials");
                        $this->redirectTo("security", "viewLogin"); exit;
                    }
                } else {
                    //ne pas etre trop précis pour ne pas donner trop d'informations à des utilisateurs malveillants
                    Session::addFlash("error", "Invalid credentials");
                    $this->redirectTo("security", "viewLogin"); exit;
                }

            }

        }

        $this->redirectTo("index", "home");
    }


    //deconnecte
    public function logout () {
        unset($_SESSION["user"]); 

        $this->redirectTo("home", "index"); exit;
    }

    //rend un utilisateur admin
    public function upgradeAdmin($id){
        $this->restrictTo("ROLE_ADMIN");
        $userManager = new UserManager();

        //tableau associatif colonne à modifier et sa valeur, pour "SET role= '..' " dans le manager
        $data =["role" => "'ROLE_ADMIN'"]; 
        $userManager->update($data, $id);

        Session::addFlash("sucess", "This user is now an admin");
        $this->redirectTo("forum", "findOneUser", $id); exit;
    }

    //rend un admin simple utilisateur
    public function upgradeUser($id){
        $this->restrictTo("ROLE_ADMIN");
        $userManager = new UserManager();

        //tableau associatif colonne à modifier et sa valeur, pour "SET role= '..' " dans le manager
        $data =["role" => "'ROLE_USER'"]; 
        $userManager->update($data, $id);

        Session::addFlash("sucess", "This admin is now an user");
        $this->redirectTo("forum", "findOneUser", $id); exit;
    }

    //suppression du compte de l'utilisateur
    public function deleteUser($id){

        // $this->restrictTo("ROLE_ADMIN");
        $userManager = new UserManager();
        $userManager->delete($id);

        Session::addFlash("success", "Profil deleted");
        $this->logout();
        $this->redirectTo("forum", "index"); exit;
    }

}