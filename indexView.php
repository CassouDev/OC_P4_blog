<?php
$blogTitle = "Billet simple pour l'Alaska";
$cssFile1 = "css/homepage.css";
$cssFile2 = "css/popup.css";
$cssFile3 = null;
$headContent = null;
$headLink = "index.php";
$imgId = "mountains";
$scr = "images/mountains.png";
$alt = "Mountains and 'Billet simple pour l'Alaska'";

ob_start(); ?>
<button id="connectButton">Connexion</button>
<div id="adminForm">
    <form method="get" action="index.php" id="connectForm">
        <p>
            <label for='pseudo'>Pseudo: </label>
            <input type='text' name='pseudo'/><br>
            <label for='password'>Mot de passe: </label>
            <input type='password' name='password'/><br>
            <input class='button' type='submit' value="Se connecter"/>
            <a href="index.php" class="button">Retour</a>
        </p>
    </form>
</div>
<?php $headerButtons = ob_get_clean();

ob_start(); ?>
        <!-- POSTS -->
        <section id='postSection'>
            <!-- Get the posts -->
            <?php
            foreach ($posts as $post) 
            {
                ?>
                <a href="php/postPage.php?chapterNb=<?= $post->chapter(); ?>">
                <div class='lastPost'>
                    <h3>
                        Chapitre <?= htmlspecialchars($post->chapter()) ?> - <?= htmlspecialchars($post->title()) ?>
                    </h3>
                </div>
                </a>
            <?php
            }
            ?>
            

        </section>

        <script src="js/connect_form.js"></script>
<?php $blogContent = ob_get_clean();

require('php/template.php'); ?>