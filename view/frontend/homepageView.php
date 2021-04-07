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
<!-- <div >
    <form method="post" action="index.php?action=homeGetPosts&amp;pseudo=<?= $pseudo; ?>" >
    <p>
        <label for='userPseudo'>Pseudo: </label>
        <input type='text' name='userPseudo'/><br>
        <label for='pass'>Mot de passe: </label>
        <input type='pass' name='pass'/><br>
        <input class='button' type='submit' value="S'inscrire"/>
        <a href="index.php" class="button">Retour</a>
    </p>
    </form>
</div> -->

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