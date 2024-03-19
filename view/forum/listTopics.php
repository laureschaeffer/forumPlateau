<?php
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
    
?>

<h1>Liste des topics</h1>

<?php
//lien de redirection vers les post sur le sujet
foreach($topics as $topic ){ ?>
    <p><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?=$topic->getId()?>"><?= $topic ?></a> par <?= $topic->getUser() ?></p>
<?php }
