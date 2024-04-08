<?php $topTopics = $result["data"]['topTopics']; 
      $topUsers = $result["data"]["topUsers"];
?>


<section id="home">
    <div id="home-intro">
        <h1>BIENVENUE SUR LE FORUM</h1>
    </div>
    <div id="home-description">
        <p>Step into a world where ideas flow freely, discussions ignite passions, and connections flourish. Our forum is more than just a virtual space; it's a vibrant hub where individuals from diverse backgrounds converge to share knowledge, exchange perspectives, and forge lasting friendships. </p>
    </div>

    <h2>Top topics</h2>
    <div id="home-top-topic">
    <?php
    //selection des topics qui ont le plus de posts, visibles meme aux personnes non connectées
    
    foreach($topTopics as $topic){  
        ?>
    <div class="top-topic-card">
        <div class="top-topic-header">
            <p class="top-topic-title"><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?=$topic->getId()?>"><?=$topic->getTitre()?></a></p>
            <p>In <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $topic->getCategory()->getId() ?>" style="color: black"><?=strtolower($topic->getCategory()) ?></a></p>
            <p><?=$topic->getDateCreation()->format('d-m-Y H:i')?></p>
            <p>Has <?=$topic->getNbPost()?> posts</p>
        </div>
        <?php //si l'utilisateur existe
        if($topic->getUser()){
            $user="<a href='index.php?ctrl=forum&action=findOneUser&id=".$topic->getUser()->getId()."'>".$topic->getUser()."</a>";
        } else {
            $user= "anonyme";
        }
            ?>
        <p> by <span class="author"><?=$user?></span></p>
    </div>
    <?php
    }
    ?>
    </div>
    
    <h2>Top users</h2>
    <div id="home-top-user">
    <?php
    foreach($topUsers as $user){  ?>
        <div class="top-user-card">
            <p><a href="index.php?ctrl=forum&action=findOneUser&id=<?=$user->getId()?>"><?=$user->getPseudo()?></a></p>
            <p>Since <?=$user->getDateInscription()->format('Y')?></p>
            <p>Has posted : <?=$user->getNbPost()?> times</p>
        </div>
        <?php 
      }
      ?>
    </div>
</section>
