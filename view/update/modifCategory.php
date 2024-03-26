<?php //-------------------- modifier une categorie

$categories= $result['data']['categories'];
?>
<div id="form-update-topic">
    <h3>Change this category name</h3>
    <form action="index.php?ctrl=forum&action=updateCategory&id=<?=$categories->getId()?>" method="post">
        <input type="text" name="name" value="<?=$categories?>">
        <div class="update-btn">
            <button class="btn" type="submit" name="submit">Update</button>
        </div>
    </form>
</div>