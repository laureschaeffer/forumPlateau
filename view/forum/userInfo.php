<?php
// detail d'un utilisateur et ses posts 
$userInfos= $result['data']['userInfos'];
$postsUser=$result['data']['postsUser'];
?>

<div id="user">
    <div class="user-info">
        <p><?=$userInfos?></p>
        <p><?=$userInfos->getDateInscription()?></p>
        <p><?=$userInfos->getRole()?></p>
    </div>
    <div class="user-post">
        <?php foreach($postsUser as $post){ ?>
            <div class="user-post-header">
                <p><?=$post->getTopic()?></p>
                <p><?=$post->getDateCreation()?></p>
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