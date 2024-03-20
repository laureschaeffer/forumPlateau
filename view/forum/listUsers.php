<?php //liste de tous les user

$users = $result['data']['users'];
?>

<div id="users">
    <h2>You may want to see these people</h2>
    <?php foreach($users as $user){ ?>
        <div class="user-listing">
            <div class="user">
                <p><?=$user?></p>
                <p><?=$user->getDateInscription()?></p>
                <!-- lien pour voir l'utilisateur  -->
                <a href="index.php?ctrl=forum&action=findOneUser&id=<?=$user->getId()?>">See more</a>
            </div>
        </div>
        
        <?php
}
?>
</div>