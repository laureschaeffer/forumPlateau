<?php  //liste des categories, lien vers la liste des sujets en lien avec les categories
    $categories = $result["data"]['categories']; 
?>

<h2>Explore our categories</h2>
<div id="categories">

<?php
foreach($categories as $category ){
    // si l'utilisateur est admin, possibilite de supprimer ou modifier 
    if(App\Session::isAdmin()){
        $delete= "<a href='index.php?ctrl=forum&action=deleteCategory&id=".$category->getId()."'><i class='fa-solid fa-trash'></i></a>";
        $change = "<a href='index.php?ctrl=forum&action=changeCategory&id=".$category->getId()."'><i class='fa-solid fa-pen'></i></a>";
    } else {
        $delete= "";
        $change= "";
    }
    ?>
    <p><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a><?= $delete.$change?> </p>

    <?php }
?>

</div>


  
