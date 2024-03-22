<?php               //listes de post en lien avec la categorie choisie
    $posts = $result["data"]['posts']; 
    $topics = $result["data"]['topics']; //pour avoir le titre de la page
    ?>


<h2><?=$topics?> publications</h2>

<?php
foreach($posts as $post ){ 
    ?>
<div id="publications">
    <div class="publication-header">
        <p><a href="index.php?ctrl=forum&action=findOneUser&id=<?=$post->getUser()->getId()?>"><?= $post->getUser() ?></a></p>
        <p><?= $post->getDateCreation()->format('d-m-Y H:i')?></p> 
    </div>
    <div class="publication-main">
        <p><?= $post ?></p>
    </div>
    <div class="line-break">
        <hr class="line"/>
    </div>
</div>
<?php }

