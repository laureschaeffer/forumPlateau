<?php
// detail de son profil et de ses posts 
$userInfos= $result['data']['userInfos'];
$postsUser=$result['data']['postsUser'];
$topicsUser=$result['data']['topicsUser'];

?>

<div id="user">
    
    <h2>Your profil</h2>
    <div class="user-info">
        <p><?=$userInfos?></p>
        <p>Since <?=$userInfos->getDateInscription()->format('d-m-Y')?></p>
        <!-- bouton pour update son profil sans changer de page, en lien avec la fonction javascript -->
        <!-- <button class="modification">Change your profil</button> -->
    </div>
    <h3>Your publications</h3>
    <div class="user-post">
        <?php 
        if($postsUser){
            foreach($postsUser as $post){ ?>
                <div class="user-post-header">
                    <p><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?=$post->getTopic()->getId()?>"><?=$post->getTopic()?></a></p>
                    <p><?=$post->getDateCreation()->format('d-m-Y H:i')?></p>
                </div>
                <div class="user-post-main">
                    <p><?=$post?></p>
                    <p><a href="index.php?ctrl=forum&action=viewUpdatePost&id=<?=$post->getId()?>">Change your post</a></p>
                    
                </div>
                <hr>
                <?php
            }
        } else { ?>
            <p>No publications created yet</p>
        <?php }
        ?>
    </div>
    <h3>Topics you created</h3>
    <div class="user-topics">
        <?php 
        if ($topicsUser){
            foreach($topicsUser as $topic){ 
                //si le topic est verouillé
                if($topic->getVerouillage() == 0){
                    $lockStatut= "<a href='index.php?ctrl=forum&action=lockTopic&id=".$topic->getId()."'><i class='fa-solid fa-lock'></i> Lock</a>";
                } else {
                    $lockStatut = "<a href='index.php?ctrl=forum&action=unlockTopic&id=".$topic->getId()."'><i class='fa-solid fa-unlock'></i> Unlock</a>";
                }
                ?>
                <div class="user-topic-main">
                    <p><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?=$topic->getId()?>"><?=$topic?></a></p>
                </div>
                <div class="user-topic-update">
                    <p><a href="index.php?ctrl=forum&action=viewUpdateTopic&id=<?=$topic->getId()?>"><i class="fa-solid fa-pen"></i> Modify</a></p>
                    <?=$lockStatut?>
                </div>
            <?php
            }
        } else { ?>
            <p>No topics created yet</p>
        <?php }
        ?>
        <h4>Delete your account</h4>
        <!-- ne pas mettre en visible l'id utilisateur, je le recupere dans le manager -->
        <p><a href="index.php?ctrl=security&action=deleteUser&id=<?=$userInfos->getId()?>">Delete</a></p>
    </div>


</div>