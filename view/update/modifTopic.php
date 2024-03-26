<?php //-------------------- modifier un topic
$topics= $result['data']['topics'];
?>

<div id="form-update-topic">
    <h3>Change your topic</h3>
    <form action="index.php?ctrl=forum&action=updateTopic&id=<?=$topics->getId()?>" method="post">
        <input type="text" name="titre" value="<?=$topics?>">
        <div class="update-btn">
            <button class="btn" type="submit" name="submit">Update</button>
        </div>
    </form>
</div>