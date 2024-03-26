<?php //-------------------- modifier un post
$posts=$result['data']['posts'];
?>

<div id="form-update-post">
    <h3>Change your publication</h3>
    <form action="index.php?ctrl=forum&action=updatePost&id=<?=$posts->getId()?>" method="post">
        <textarea name="texte"><?=$posts?></textarea>
        <div class="update-btn">
            <button class="btn" type="submit" name="submit">Update</button>
        </div>
    </form>
</div>
