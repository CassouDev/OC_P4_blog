<?php
$blogTitle = "Billet simple pour l'Alaska";
$cssFile1 = "public/css/homepage.css";
$cssFile2 = "public/css/popup.css";
$cssFile3 = "public/css/post.css";
$headLink = "index.php";
$imgId = "mountains";
$scr = "public/images/mountains.png";
$alt = "Mountains and 'Billet simple pour l'Alaska'";

ob_start(); ?>
<script src="https://kit.fontawesome.com/1d97b80b9e.js" crossorigin="anonymous"></script>
<?php $headContent = ob_get_clean();

ob_start(); ?>
<button id="connectButton">Connexion</button>
<a href="index.php" alt="Bouton de retour à l'accueil" id="returnButton">Accueil</a>

<div id="adminForm">
    <form method="get" action="index.php" id="connectForm">
        <p>
            <label for="pseudo">Pseudo: </label>
            <input type="text" name="pseudo"/><br>
            <label for="password">Mot de passe: </label>
            <input type="password" name="password"/><br>
            <input class="button" type="submit" value="Se connecter"/>
            <a href="index.php?action=postPage&amp;chapterNb=<?= $_GET['chapterNb']; ?>" class="button">Retour</a>
            </p>
    </form>
</div>
<?php $headerButtons = ob_get_clean();

ob_start(); ?>
<!-- Display a post -->
<section id='postSection'>
    <!-- PopUp messages -->
    <?php
    if (isset($message))
    {
    ?>
        <div class="popUp">
            <p><?= $message ?></p>
            <a href="index.php?action=postPage&amp;chapterNb=<?= $_GET['chapterNb']; ?>" class="button">Ok</a>
        </div>
    <?php
    }

    foreach ($onePost as $post) 
    {
    ?>
        <h1>
            <a href="index.php?action=postPage&amp;chapterNb=<?= $_GET['chapterNb'] ?>&amp;previousChapter">
                <span style="font-size: 58px; color: white;">
                    <i class="fas fa-caret-left" alt="Simple white arrow to the previous chapter"></i>
                </span>
            </a>
            <p>
                Chapitre <?= $_GET['chapterNb'] ?> - <?= htmlspecialchars($post->title())?>
            </p>
            <a href="index.php?action=postPage&amp;chapterNb=<?= $_GET['chapterNb'] ?>&amp;nextChapter">
                <span style="font-size: 58px; color: white;">
                    <i class="fas fa-caret-right" alt="Simple white arrow to the next chapter"></i>
                </span>
            </a>
        </h1>
        <h2><?= htmlspecialchars($post->postDate()) ?></h2>
        <p><?= $post->content() ?></p>
    <?php
    }
    ?>
</section>

<section id='commentSection'>
    <h1 id="commentsTitle">Commentaires (<?= $commentsNumber ?>)</h1>
    <!-- Display comments -->
    <div id="comments">
        <?php 
        foreach ($comments as $comment) 
        {
        ?>
            <div id="eachComment">
                <p><strong> <?= htmlspecialchars($comment->pseudo()) ?></strong> le <?= htmlspecialchars($comment->commentDate()) ?></p>
                <p><?= htmlspecialchars($comment->comment()) ?></p>
                <a href="index.php?action=postPage&amp;chapterNb=<?= $_GET['chapterNb'] ?>&amp;id=<?= $comment->id() ?>&amp;reportComment" id="reportButton">Signaler</a>
            </div>
        <?php 
        } 
        ?>
    </div>

    <!-- Adding comments form -->
    <h1 id="letComment">Laisser un commentaire</h1>

    <div id="commentForm">
        <form method="post" action="index.php?action=postPage&amp;chapterNb=<?= $_GET['chapterNb'] ?>">
            <p>
                <label for="pseudo">Pseudo: </label>
                <input type="text" name="pseudo"/><br>
                <textarea cols="100" rows="10" name="comment"></textarea><br>
                <input class="button" type="submit" value="Commenter" name="commentButton"/>
            </p>
        </form>
    </div>
</section>

<script src="public/js/connect_form.js"></script>

<?php $blogContent = ob_get_clean();

require('view/template.php'); ?>