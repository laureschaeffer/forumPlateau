<?php
    $posts = $result["data"]['posts']; 
    ?>

<h1>Liste des postes</h1>

<?php
foreach($posts as $post ){ ?>
    <p><?= $post ?></a></p>
<?php }

