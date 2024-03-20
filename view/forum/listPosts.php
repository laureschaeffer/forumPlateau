<?php               //listes de post en lien avec la categorie choisie
    $posts = $result["data"]['posts']; 
    ?>

<!-- $post->getDateCreation()->format('d-m-Y H:i') -->
<h1>Liste des postes</h1>

<?php
foreach($posts as $post ){ 
    ?>
<div id="publications">
    <div class="publication-header">
        <p><?= $post->getUser() ?></p>
        <p><?= $post->getDateCreation()?></p> 
    </div>
    <div class="publication-main">
        <p><?= $post ?></p>
    </div>
    <div class="line-break">
        <hr class="line"/>
    </div>
</div>
<?php }

