<?php  //listes des sujets en lien avec une catégorie, avec l'utilisateur qui l'a créé
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 

    //si utilisateur connecté
    if($_SESSION != NULL){ ?>
        <h2><?=$category?> topics</h2>
        <div id="topics">
            <div class="topic-listing">
                <?php
        foreach($topics as $topic ){ 

            // si verouillage = 0 (pas verouillé) afficher le cadenas pour verouiller, sinon afficher qu'il est déjà verouillé ; action pour le lien plus bas
            if($topic->getVerouillage() == 0){
                $lockStatut= "<i class='fa-solid fa-unlock'></i>"; 
                $action="<p><a href='index.php?ctrl=forum&action=lockTopic&id=".$topic->getId()."'>Vérouiller</a></p>";
            } else {
                $lockStatut = "<i class='fa-solid fa-lock'></i>";
                $action="<p><a href='index.php?ctrl=forum&action=unlockTopic&id=".$topic->getId()."'>Déverouiller</a></p>";
            }
            //verifie si le topic a été créé par l'utilisateur connecté ou un autre
            $userTopic=$topic->getUser()->getId();
            $userSession =$_SESSION['user']->getId();
            ($userTopic == $userSession ? $user = "you" : $user= $topic->getUser()); 
            //lien de la personne qui a créée, et pas de lien si c'est l'utilisateur
            ($userTopic == $userSession ? $lien = $user : $lien= "<a href=index.php?ctrl=forum&action=findOneUser&id=$userTopic>$user</a>"); 
            ?>

            <p><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?=$topic->getId()?>"><?= $topic ?></a> <?=$lockStatut?> by <?=$lien?></a></p>
            <?php
            //si personne admin OU auteur du topic tu peux faire une action 
            if(App\Session::isAdmin() || $userTopic == $userSession){
                echo $action;
            } 
        }
            ?>    
            </div>
            <div class="topic-form">
                <h2>Create a new topic</h2>
                <!-- ajoute un topic, avec son premier message, recupere l'id de la categorie de la page  -->
                <form action="index.php?ctrl=forum&action=formTopic&id=<?=$category->getId()?>" method="post">
                    <label for="titre"></label>
                    <input type="text" name="titre" id="titre" placeholder="Title" require><br>
            
                    <!-- valeur qui ira dans post avec id_topic de celui nouvellement créé  -->
                    <label for="texte"></label>
                    <textarea name="texte" id="texte" placeholder="First message" require></textarea><br>
                    <!-- <input type="text" name="texte" id="texte" placeholder="First message" require><br> -->
            
                    <div class="btn-container">
                        <button class="btn" type="submit" name="submit">Create</button>
                    </div>

                </form>
                
            </div>
        </div>
<?php
    } else {
        echo "<p>Se connecter ou s'inscrire pour voir les topics</p>";
    }

    

