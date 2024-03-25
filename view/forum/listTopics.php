<?php  //listes des sujets en lien avec une catégorie, avec l'utilisateur qui l'a créé
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
    ?>

<h2><?=$category?> topics</h2>
<div id="topics">
    <div class="topic-listing">
<?php
foreach($topics as $topic ){ 
    // si verouillage = 0 (pas verouillé) afficher le cadenas pour verouiller, sinon afficher qu'il est déjà verouillé
    if($topic->getVerouillage() == 0){
        $lockStatut= "<i class='fa-solid fa-unlock'></i>"; 
    } else {
        $lockStatut = "<i class='fa-solid fa-lock'></i>";
    }
    //verifie si le topic a été créé par l'utilisateur connecté ou un autre
    $userTopic=$topic->getUser()->getId();
    $userSession =$_SESSION['user']->getId();
    ($userTopic == $userSession ? $user = "you" : $user= $topic->getUser()); 
    //pas de lien si on est la personne qui a créée
    ($userTopic == $userSession ? $lien = $user : $lien= "<a href=index.php?ctrl=forum&action=findOneUser&id=$userTopic>$user</a>"); 
    
    //si personne admin OU auteur du topic tu peux verouiller, sinon pas de lien
    if(App\Session::isAdmin() || $userTopic == $userSession){
        $lock="<a href='index.php?ctrl=forum&action=lockTopic&id=".$topic->getId()."'><i class='fa-solid fa-lock'></i></a>";
    } else{
        $lock="";
    }
    ?>

    <p><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?=$topic->getId()?>"><?= $topic ?></a> <?=$lock?> by <?=$lien?></a></p>
    <?php
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
