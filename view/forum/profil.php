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
    <?php
    //si l'utilisateur est banni
    if($userInfos->getBan()==1){ ?>
       <div class="user-ban-ls">
            <p>You haven't respect our rules, an admin banned you, which means you can't : </p>
            <ul>
                <li>Post anything</li>
                <li>Unlock or lock your topics</li>
                <li>Update your topics or posts</li>
            </ul>
            <p>But you can still : </p>
            <ul>
                <li>Change your profil</li>
                <li>Delete your post</li>
                <li>Delete your account</li>
            </ul>
            <p>We will inform you when the ban is lifted.</p>
       </div> 
       <?php
    } 

    ?>
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
                    <?php if($userInfos->getBan()==0){ ?>
                        <p><a href="index.php?ctrl=forum&action=viewUpdatePost&id=<?=$post->getId()?>">Change your post</a></p>
                        <?php
                    }
                    ?>
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
                <?php if($userInfos->getBan()==0){ ?>
                    <div class="user-topic-update">
                        <p><a href="index.php?ctrl=forum&action=viewUpdateTopic&id=<?=$topic->getId()?>"><i class="fa-solid fa-pen"></i> Modify</a></p>
                        <?=$lockStatut?>
                    </div>
                <?php

                }
            }
        } else { ?>
            <p>No topics created yet</p>
    </div>
        <?php }
        ?>
    <h4>Delete your account</h4>
    <p><a href="index.php?ctrl=security&action=deleteUser&id=<?=$userInfos->getId()?>">Delete</a></p>


</div>