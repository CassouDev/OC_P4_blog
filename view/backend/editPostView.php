<?php
$imgId = "mountains_admin";
$scr = "public/images/admin.png";
$alt = "Mountains";

ob_start(); ?>
    <link rel="stylesheet" media="screen" href="public/css/admin.css"/>
    <link rel="stylesheet" media="screen" href="public/css/popup.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Tiny MCE -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#mytextarea'
        });
    </script>
<?php $headContent = ob_get_clean();

ob_start(); ?>
    <a href="index.php?action=admin&amp;disconnect" id="disconnectButton">Déconnexion</a>
    <a href="index.php?action=admin" id="returnButton">Retour</a>
<?php $headerButtons = ob_get_clean();

ob_start(); ?>
<div class="adminContent">
    <div class="bigTitle">
        <h1 >Modifier mon billet</h1>
    </div>

    <div >
        <?php 
        foreach($onePost as $post)
        {
        ?>
            <p id="chapterNumber">
                Chapitre <?= $post->chapter(); ?>
            </p>

            <form method='post' action="index.php?action=editPost&amp;chapterId=<?= $_GET['chapterId'] ?>">
                <label for="inputTitle">Titre:</label>
                <input id="inputTitle" type="text" name="title" value="<?= htmlspecialchars($post->title()); ?>"/><br>
                <textarea id="mytextarea" name="content" cols="70" rows="20"><?= ($post->content()); ?></textarea><br>
                        
                <div id="buttons">
                    <input class="button" type="submit" value="Modifier"/>

                    <?php
                    if($_GET['chapterNb'] == $count)
                    {
                    ?>
                        <a href="index.php?action=admin&amp;chapterId=<?= $_GET['chapterId']; ?>&amp;deletePost" class="button" id="deleteButton">Supprimer</a>
                    <?php
                    }
                    ?>
                </div>
            </form>
        <?php 
        }
        ?>
    </div>
</div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<?php $blogContent = ob_get_clean();

require('view/template.php'); ?>