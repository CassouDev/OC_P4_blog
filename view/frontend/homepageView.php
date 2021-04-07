<?php
$imgId = "mountains";
$scr = "public/images/mountains.png";
$alt = "Mountains";

ob_start(); ?>
    <link rel="stylesheet" media="screen" href="public/css/homepage.css"/>
    <link rel="stylesheet" media="screen" href="public/css/popup.css"/>
<?php $headContent = ob_get_clean();

ob_start(); ?>
    <button class='button' id="connectButton">Connexion</button>

    <div id="adminForm">
        <form method="post" action="index.php" id="connectForm">
            <label for='connectPseudo'>Pseudo: </label>
            <input type='text' name='pseudo' id='connectPseudo'/><br>
            <label for='password'>Mot de passe: </label>
            <input type='password' name='password' id='password'/><br>
            <div id="connectButtons">
                <input class='button' type='submit' value="Se connecter"/>
                <a href="index.php" class="button">Retour</a>
            </div>
        </form>
    </div>
<?php $headerButtons = ob_get_clean();

ob_start(); ?>
    <!-- POSTS -->
    <section id='postSection'>
        <?php
        foreach ($posts as $post) 
        {
        ?>
            <a href="index.php?action=postPage&amp;chapterId=<?= $post->id(); ?>&amp;chapterNb=<?= htmlspecialchars($post->chapter()); ?>">
                <div class='lastPost'>
                    <h1>
                        Chapitre <?= $post->chapter(); ?> - <?= htmlspecialchars($post->title()); ?>
                    </h1>
                </div>
            </a>
        <?php
        }
        ?>
    </section>

    <script src="public/js/connect_form.js"></script>
<?php $blogContent = ob_get_clean();

require('view/template.php'); ?>