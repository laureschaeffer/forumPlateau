<?php $topTopics = $result["data"]['topTopics']; 
      $topUsers = $result["data"]["topUsers"];
?>


<section id="home">
    <div id="home-intro">
        <h1>BIENVENUE SUR LE FORUM</h1>
        <!-- <figure>
            <img src="../public/img/undraw_Chat_re_re1u.png" alt="home-logo">
        </figure> -->
    </div>
    <id id="home-description">
        <p>Step into a world where ideas flow freely, discussions ignite passions, and connections flourish. Our forum is more than just a virtual space; it's a vibrant hub where individuals from diverse backgrounds converge to share knowledge, exchange perspectives, and forge lasting friendships.<br>
        Whether you're here to seek advice, engage in stimulating debates, or simply unwind with like-minded enthusiasts, you've found the right place. Our community thrives on respectful dialogue, fostering an atmosphere where everyone's voice is heard and valued.<br>
        Join us in exploring a myriad of topics spanning from technology and science to arts and culture. Dive into engaging conversations, pose thought-provoking questions, and expand your horizons alongside fellow members who are as passionate about learning and growth as you are.<br>
        Embrace the spirit of camaraderie, curiosity, and collaboration as we embark on this journey together. Welcome aboard!</p>
    </id>

    <h2>Top topics</h2>
    <id id="home-top-topic">
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
    </id>
    
    <h2>Top users</h2>
    <id id="home-top-user">
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
    </id>
</section>
