<?php  //liste des categories, lien vers la liste des sujets en lien avec les categories
    $categories = $result["data"]['categories']; 
?>

<h2>Explore our categories</h2>
<section id="categories">

<?php
foreach($categories as $category ){ ?>
    <div class="categorie-main">
        <p><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a></p>
    </div>
    <?php
    // si l'utilisateur est admin, possibilite de supprimer ou modifier 
    if(App\Session::isAdmin()){ ?>
    <a href='index.php?ctrl=forum&action=viewUpdateCategory&id=<?=$category->getId()?>' class="categorie-update"><i class='fa-solid fa-pen'></i>Change</a>
    <?php
    } 
 }

 if(App\Session::isAdmin()){ ?>
    <div class="category-form">
        <h2>Create a new category</h2>
        <form action="index.php?ctrl=forum&action=addCategory" method="post">
            <label for="name"></label>
            <input type="text" name="name" id="name" placeholder="Name" required><br>

            <div class="btn-container">
                <button class="btn" type="submit" name="submit">Create</button>
            </div>
        </form>
    </div>
<?php    
 }
?>

</section>


  
