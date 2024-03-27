<?php //liste de tous les user

$users = $result['data']['users'];
?>

<div id="users">
    <h2>Our users</h2>
    <?php foreach($users as $user){ ?>
        <div class="user-listing">
            <div class="user">
                <p><?=$user?></p>
                <p>Since <?=$user->getDateInscription()->format('d-m-Y')?></p>
                <!-- role de la personne  -->
                <p class="user-role"><?=$user->getRoleUser()?></p>
                <!-- lien pour voir l'utilisateur  -->
                <a href="index.php?ctrl=forum&action=findOneUser&id=<?=$user->getId()?>">See more</a>
            </div>
        </div>
        
        <?php
}
?>
</div>