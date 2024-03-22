<?php
// detail d'un utilisateur et ses posts 
$userInfos= $result['data']['userInfos'];
$postsUser=$result['data']['postsUser'];
?>

<div id="user">
    <div class="user-info">
        <p><?=$userInfos?></p>
        <p>Since <?=$userInfos->getDateInscription()->format('d-m-Y')?></p>
    </div>
    <div class="user-post">
        <?php foreach($postsUser as $post){ ?>
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
        ?>
    </div>


</div>