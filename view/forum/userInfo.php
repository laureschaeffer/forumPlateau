<?php
// detail d'un utilisateur et ses posts 
$userInfos= $result['data']['userInfos'];
$postsUser=$result['data']['postsUser'];

if(App\Session::getUser()){ //si l'utilisateur est connecté ?>
    <div id="user">
        <div class="user-info">
            <p><?=$userInfos?></p>
            <p>Since <?=$userInfos->getDateInscription()->format('d-m-Y')?></p>
            <p class="user-role"><?=$userInfos->getRoleUser()?></p>
            <?php
            //si la personne connectée est admin, et que le profil ne l'est pas, on peut changer le statut de l'utilisateur
            if(App\Session::isAdmin() && ($userInfos->getRole() === "ROLE_USER")){
                $lienRole="<a href='index.php?ctrl=security&action=upgradeAdmin&id=".$userInfos->getId()."'>Make them admin</a>";
                $lienBannir =  "<a href='index.php?ctrl=security&action=banUser&id=".$userInfos->getId()."'>Ban this user</a>";
            } else { //juste connaitre le role
                $lienRole= "";
                $lienBannir= "";
            }
            ?>
            <p><?=$lienRole?></p>
            <p><?=$lienBannir?></p>
            <p>Has posted <?=$userInfos->getNbPost()?> times</p>
        </div>
        <?php 
        if($postsUser){
            
            foreach($postsUser as $post){ ?>
                <div class="user-post">
                    <div class="user-post-header">
                        <p><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?=$post->getTopic()->getId()?>"><?=$post->getTopic()?></a></p>
                        <p><?=$post->getDateCreation()->format('d-m-Y H:i')?></p>
                    </div>
                    <div class="user-post-main">
                        <p><?=$post?></p>
                    </div>
                </div>
                <div class="line-break">
                    <hr class="line">
                </div>
                <?php
                }

        } else {
            echo "<p>No posts yet</p>" ;
        } 
        ?>
    </div>
<?php
} else {
    echo "<p>Login or create an account to see this.</p>";
}

