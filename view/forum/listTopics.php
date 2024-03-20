<?php  //listes des sujets en lien avec une catégorie, avec l'utilisateur qui l'a créé
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
    ?>

<h2><?=$category?> topics</h2>
<div id="topics">
    <div class="topic-listing">
        <?php
//lien de redirection vers les post sur le sujet
foreach($topics as $topic ){ ?>
        <p><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?=$topic->getId()?>"><?= $topic ?></a> by <a href="index.php?ctrl=forum&action=findOneUser&id=<?=$topic->getUser()->getId()?>"><?= $topic->getUser() ?></a></p>
        <?php }
        // condition locked ici 
        ?>
    </div>
    <div class="topic-form">
        <h2>Create a new topic</h2>
        <label for="titre"></label>
        <input type="text" name="titre" id="titre" placeholder="Title" require><br>

        <!-- valeur qui ira dans post avec id_topic de celui nouvellement créé  -->
        <label for="texte"></label>
        <input type="text" name="texte" placeholder="First message" require><br>

        <!-- lien vers une redirection  -->
        <button class="btn"><a href="#">Create</a></button>
        
    </div>
</div>
