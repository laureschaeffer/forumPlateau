<?php  //liste des categories, lien vers la liste des sujets en lien avec les categories
    $categories = $result["data"]['categories']; 
?>

<h2>Explore our categories</h2>
<div id="categories">

<?php
foreach($categories as $category ){ ?>
    <p><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a></p>
    <?php }
?>

</div>


  
