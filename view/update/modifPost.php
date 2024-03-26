<?php
$posts=$result['data']['posts'];
?>

<h3>Your publications</h3>
<form action="index.php?ctrl=forum&action=updatePost&id=<?=$posts->getId()?>" method="post" class="form-update-post">
    <input type="text" name="texte" id="texte" value="<?=$posts?>">
    <div>
        <button class="btn" type="submit" name="submit">Update</button>
    </div>
</form>

