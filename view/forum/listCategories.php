<?php  //liste des categories, lien vers la liste des sujets en lien avec les categories
    $categories = $result["data"]['categories']; 
?>

<h2>Explore our categories</h2>
<div id="categories">

<?php
foreach($categories as $category ){ ?>
    <p><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a></p>
    <?php
    // si l'utilisateur est admin, possibilite de supprimer ou modifier 
    if(App\Session::isAdmin()){ ?>
        <a href='index.php?ctrl=forum&action=changeCategory&id=<?=$category->getId()?>'><i class='fa-solid fa-pen'></i></a>
    <?php
    } 
 }
?>

</div>


  
