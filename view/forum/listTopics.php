<?php  //listes des sujets en lien avec une catégorie, avec l'utilisateur qui l'a créé
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
    ?>

<h1>Explore topics</h1>
<div id="topics">
    <div class="topic-listing">
        <?php
//lien de redirection vers les post sur le sujet
foreach($topics as $topic ){ ?>
        <p><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?=$topic->getId()?>"><?= $topic ?></a> by <?= $topic->getUser() ?></p>
        <?php }
        // condition locked ici 
        ?>
    </div>
    <div class="topic-form">
        <h2>Create a new topic</h2>
        <label for="titre"></label>
        <p><input type="text" name="titre" id="titre" placeholder="Title" require></p>

        <!-- valeur qui ira dans post avec id_topic de celui nouvellement créé  -->
        <label for="texte"></label>
        <p class="form-text"><input type="text" name="texte" placeholder="First message" require></input></p>

        <!-- lien vers une redirection  -->
        <a href="#"><button class="btn"></button></a>
        
    </div>
</div>
