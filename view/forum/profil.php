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
                </div>
                <hr />
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
                if($topic->getVerouillage() == 1){
                    $lockStatut= "<i class='fa-solid fa-lock'></i>";
                } else {
                    $lockStatut = "";
                }
                ?>
                <p><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?=$topic->getId()?>"><?=$topic." ".$lockStatut?></a></p>
                
            <?php
            }
        } else { ?>
            <p>No topics created yet</p>
        <?php }
        ?>
    </div>


</div>