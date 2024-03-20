<?php  //liste des categories, lien vers la liste des sujets en lien avec les categories
    $categories = $result["data"]['categories']; 
?>

<h1>Explore our categories</h1>

<?php
foreach($categories as $category ){ ?>
<div id="categories">
    <p><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a></p>
</div>
<?php }


  
