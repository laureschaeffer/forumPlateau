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
        $lockStatut= "<a href='index.php?ctrl=forum&action=lockTopic&id=".$topic->getId()."'><i class='fa-solid fa-unlock'></i></a>"; 
        // $lockStatut= "<i class='fa-solid fa-unlock'></i>";
    } else {
        $lockStatut = "<i class='fa-solid fa-lock'></i>";
    }
    ?>
        <p><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?=$topic->getId()?>"><?= $topic ?></a> <?=$lockStatut?> by <a href="index.php?ctrl=forum&action=findOneUser&id=<?=$topic->getUser()->getId()?>"><?= $topic->getUser() ?></a></p>
        <?php 
        //si personne admin OU auteur du topic (a faire)
        if(App\Session::isAdmin()){
            $lock="<a href='index.php?ctrl=forum&action=lockCategory&id=".$category->getId()."'><i class='fa-solid fa-unlock'></i></a>";
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
            <input type="text" name="texte" placeholder="First message" require><br>
    
            <button class="btn" type="submit" name="submit">Create</button>

        </form>
        
    </div>
</div>
