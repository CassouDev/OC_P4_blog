<?php
$blogTitle = "Billet simple pour l'Alaska";
$cssFile1 = "public/css/homepage.css";
$cssFile2 = "public/css/popup.css";
$cssFile3 = null;
$headContent = null;
$headLink = "index.php";
$imgId = "mountains";
$scr = "public/images/mountains.png";
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
            <!-- PopUp messages -->
            <?php
            if (isset($message))
            {
            ?>
                <div class="popUp">
                    <p><?= $message ?></p>
                    <a href="index.php" class="button">Ok</a>
                </div>
            <?php
            }
            ?>
            <!-- Get the posts -->
            <?php
            foreach ($posts as $post) 
            {
                ?>
                <a href="controller/postPage.php?chapterNb=<?= $post->chapter(); ?>">
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

        <script src="public/js/connect_form.js"></script>
<?php $blogContent = ob_get_clean();

require('view/template.php'); ?>