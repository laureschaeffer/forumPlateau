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
                    foreach($topics as $topic){                         
                        // si verouillage = 0 (pas verouillé) pas de cadenas, sinon afficher qu'il est verouillé ; action pour le lien plus bas pour vérouiller
                        if($topic->getVerouillage() == 0){
                            $lockStatut= ""; 
                            $action="<a href='index.php?ctrl=forum&action=lockTopic&id=".$topic->getId()."' class='topic-update'><i class='fa-solid fa-lock'></i> Lock</a>";
                        } else {
                            $lockStatut = "<i class='fa-solid fa-lock'></i>";
                            $action="<a href='index.php?ctrl=forum&action=unlockTopic&id=".$topic->getId()."' class='topic-update'><i class='fa-solid fa-unlock'></i>  Unlock</a>";
                        }
                        //si on peut récupérer l'utilisateur qui a créé un topic (si la personne a supprimé son compte ça renvoie false)
                        if($topic->getUser()){
                            $userTopic=$topic->getUser()->getId();
                            $userSession =$_SESSION['user']->getId();
                            //verifie si le topic a été créé par l'utilisateur connecté
                            if($userTopic == $userSession){
                                $user = "<span class='author'>you</span>";
                                $lienUser = $user;
                            } else {
                                $user= $topic->getUser(); 
                                $lienUser= "<a href=index.php?ctrl=forum&action=findOneUser&id=$userTopic>$user</a>";
                            }
                            //lien de la personne qui a créée, et pas de lien si c'est l'utilisateur
                        } else {
                            $userTopic= "<span class='author'>anonyme</span>"; 
                            $lienUser= "<span class='author'>anonyme
                            ";
                            $userSession="";
                        }
                        ?>
                        <div class="topic">
                            <p class="topic-title"><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?=$topic->getId()?>"><?= $topic ?></a> <?=$lockStatut?></p>
                            <p>    -by <span class='author'><?=$lienUser.", ".$topic->getDateCreation()->format('d-m-Y H:i')?> </span></p>
                            <?php
                            //si personne admin OU auteur du topic tu peux faire une action 
                            if(App\Session::isAdmin() || $userTopic == $userSession){ ?>
                            <div class="topic-update">
                                <p><?=$action?><a href='index.php?ctrl=forum&action=viewUpdateTopic&id=<?=$topic->getId()?>'><i class='fa-solid fa-pen'></i> Modify</a></p>
                            </div>
                            <?php
                        } 
                        ?>
                        </div>
                        <?php
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
        echo "<p>Login or create an account to see topics.</p>";
    }

    

