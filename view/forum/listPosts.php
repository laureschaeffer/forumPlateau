<?php               //listes de post en lien avec la categorie choisie
    $posts = $result["data"]['posts']; 
    $topics = $result["data"]['topics']; //pour avoir le titre de la page
    $category= strtolower($topics->getCategory()); //pour avoir le nom du topic de la categorie
    ?>


<h2><?=$topics?> publications</h2>

<div id="publications">
<?php
if($posts){
    foreach($posts as $post ){ 
        //verifie si le topic a été créé par l'utilisateur connecté ou un autre
        $userTopic=$post->getUser()->getId();
        $userSession =$_SESSION['user']->getId();
        //si la personne connectée est la personne qui a publié le post
        if($userTopic == $userSession){
            $user = "you";
            $lien = $user; //pas de lien vers les infos d'une personne
            $supprimerPost= "<a href='index.php?ctrl=forum&action=deletePost&id=".$post->getId()."'>Supprimer</a>";
        } else {
            $user= $post->getUser(); 
            $lien= "<a href=index.php?ctrl=forum&action=findOneUser&id=$userTopic>$user</a>"; 
            $supprimerPost= "";
        }
        ?>
    <div class="publication">
        <div class="publication-header">
            <p><?=$lien ?></a></p>
            <p><?= $post->getDateCreation()->format('d-m-Y H:i')?></p> 
            <p><?=$supprimerPost?></p>
        </div>
        <div class="publication-main">
            <p><?= $post ?></p>
        </div>
    </div>
    <div class="line-break">
        <hr class="line"/>
    </div>
    <?php }
    } else {
        echo "<p>No posts yet</p>";
    }
    ?>
    <div class="post-gbt">
        <p>Go back to <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?=$topics->getCategory()->getId()?>"><?=$category?></a> publications</p>
    </div>
    <!-- ajoute un post  -->
    <div class="post-form">
        <h2>Add a post </h3>
        <form action="index.php?ctrl=forum&action=addPost&id=<?=$topics->getId()?>" method="post" >
            <label for="texte"></label>
            <textarea name="texte" id="texte" placeholder="Your message" required></textarea>
            <div class="btn-container">
                <button class="btn" type="submit" name="submit">Create</button>
            </div>
        </form>
    </div>
</div>
