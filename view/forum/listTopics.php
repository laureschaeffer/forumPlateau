<?php  //listes des sujets en lien avec une catégorie, avec l'utilisateur qui l'a créé et sa date
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 

    //si utilisateur connecté
    if(App\Session::getUser()){ 
        ?>
        <h2><?=$category?> topics</h2>
        <div id="topics">
            <div class="topic-listing">
                <?php
                //si des topics de la categorie existe
                if($topics) {

                    foreach($topics as $topic ){ 
        
                        // si verouillage = 0 (pas verouillé) pas de cadenas, sinon afficher qu'il est verouillé ; action pour le lien plus bas pour vérouiller
                        if($topic->getVerouillage() == 0){
                            $lockStatut= ""; 
                            $action="<p><a href='index.php?ctrl=forum&action=lockTopic&id=".$topic->getId()."' class='topic-update'><i class='fa-solid fa-lock'></i> Lock</a></p>";
                        } else {
                            $lockStatut = "<i class='fa-solid fa-lock'></i>";
                            $action="<p><a href='index.php?ctrl=forum&action=unlockTopic&id=".$topic->getId()."' class='topic-update'><i class='fa-solid fa-unlock'></i>  Unlock</a></p>";
                        }
                        //si on peut récupérer l'utilisateur qui a créé un topic (si la personne a supprimé son compte ça renvoie false)
                        if($topic->getUser()){
                            $userTopic=$topic->getUser()->getId();
                            $userSession =$_SESSION['user']->getId();
                            //verifie si le topic a été créé par l'utilisateur connecté
                            $userTopic == $userSession ? $user = "<i>you</i>" : $user= $topic->getUser(); 
                            //lien de la personne qui a créée, et pas de lien si c'est l'utilisateur
                            ($userTopic == $userSession ? $lienUser = $user : $lienUser= "<a href=index.php?ctrl=forum&action=findOneUser&id=$userTopic>$user</a>"); 
                        } else {
                            $userTopic= "<i>anonyme</i>"; 
                            $lienUser= "<i>anonyme</i>";
                            $userSession="";
                        }
                        ?>
                        <div class="topic">
                            <p><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?=$topic->getId()?>"><?= $topic ?></a> <?=$lockStatut?></p>
                            <p>    -by <?=$lienUser.", ".$topic->getDateCreation()->format('d-m-Y H:i')?> </p>
                        </div>
                        <?php
                        //si personne admin OU auteur du topic tu peux faire une action 
                        if(App\Session::isAdmin() || $userTopic == $userSession){
                            echo $action;
                        } 
                        //seulement un admin peut supprimer un topic
                        if(App\Session::isAdmin()){ ?>
                            <p><a href="index.php?ctrl=forum&action=deleteTopic&id=<?=$topic->getId()?>" class='topic-update'><i class="fa-solid fa-trash"></i> Delete</a></p>
                        <?php }
                    }
                } else {
                    echo "<p>No topic for this category yet</p>";
                }
                ?>    
            </div>
            <div class="topic-form">
                <h2>Create a new topic</h2>
                <!-- ajoute un topic, avec son premier message, recupere l'id de la categorie de la page  -->
                <form action="index.php?ctrl=forum&action=addTopic&id=<?=$category->getId()?>" method="post">
                    <label for="titre"></label>
                    <input type="text" name="titre" id="titre" placeholder="Title" required><br>
            
                    <!-- valeur qui ira dans post avec id_topic de celui nouvellement créé  -->
                    <label for="texte"></label>
                    <textarea name="texte" id="texte" placeholder="First message" required></textarea><br>
            
                    <div class="btn-container">
                        <button class="btn" type="submit" name="submit">Create</button>
                    </div>

                </form>
                
            </div>
        </div>
<?php
    } else {
        echo "<p>Login or create an account to see the topics</p>";
    }

    

