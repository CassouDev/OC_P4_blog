<?php
$imgId = "mountains";
$scr = "public/images/mountains.png";
$alt = "Mountains";

ob_start(); ?>
    <link rel="stylesheet" media="screen" href="public/css/homepage.css"/>
    <link rel="stylesheet" media="screen" href="public/css/popup.css"/>
    <link rel="stylesheet" media="screen" href="public/css/post.css"/>
<?php $headContent = ob_get_clean();

ob_start(); ?>
<button class= 'button' id="connectButton">Connexion</button>

<a href="index.php" class='button' id="returnButton">Accueil</a>

<div id="adminForm">
    <form method="post" action="index.php" id="connectForm">
        <label for="connectPseudo">Pseudo: </label>
        <input type="text" name="pseudo" id="connectPseudo"/><br>
        <label for="password">Mot de passe: </label>
        <input type="password" name="password" id="password"/><br>
        <div id="connectButtons">
            <input class="button" type="submit" value="Se connecter"/>
            <a href="index.php?action=postPage&amp;chapterId=<?= $_GET['chapterId']; ?>&amp;chapterNb=<?= $_GET['chapterNb']; ?>" class="button">Retour</a>
        </div>
    </form>
</div>
<?php $headerButtons = ob_get_clean();

ob_start(); ?>
<!-- Display a post -->
<section id='postSection'>
    <?php
    foreach ($onePost as $post) 
    {
        foreach ($postId as $chapterid) 
        {
        ?>
            <div class="chapter">
                <a href="index.php?action=postPage&amp;chapterId=<?= $chapterid->id(); ?>&amp;chapterNb=<?= $_GET['chapterNb']; ?>&amp;previousChapter">
                    <img src="public/images/left-arrow.png" alt="flèche billet précédent">
                </a>

                <h1>
                    Chapitre <?= $post->chapter(); ?> - <?= htmlspecialchars($post->title()); ?>
                </h1>

                <a href="index.php?action=postPage&amp;chapterId=<?= $chapterid->id(); ?>&amp;chapterNb=<?= $_GET['chapterNb']; ?>&amp;nextChapter">
                    <img src="public/images/right-arrow.png" alt="flèche billet suivant">
                </a>
            </div>
        <?php
        }
        ?>
        
        <div class='content'>
            <div>
                <?= $post->content(); ?>   
            </div>

            <p class="postDate">
                Posté le <?= $post->postDate(); ?>
            </p>
        </div>
    <?php
    }
    ?>
</section>

<section id='commentSection'>
    <h1 id="commentsTitle">
        Commentaires (<?= $commentsNumber ?>)
    </h1>
    
    <!-- Display comments -->
    <div id="comments">
        <?php 
        foreach ($comments as $comment) 
        {
        ?>
            <div class="eachComment">
                <p>
                    <strong> <?= htmlspecialchars($comment->pseudo()); ?></strong> le <?= $comment->commentDate(); ?>
                </p>

                <p>
                    <?= htmlspecialchars($comment->comment()); ?>
                </p>

                <a href="index.php?action=postPage&amp;chapterId=<?= $_GET['chapterId']; ?>&amp;chapterNb=<?= $_GET['chapterNb']; ?>&amp;id=<?= $comment->id(); ?>&amp;reportComment" class="reportButton">Signaler</a>
            </div>
        <?php 
        } 
        ?>
    </div>

    <!-- Adding comments form -->
    <h1 id="letComment">Laisser un commentaire</h1>

    <div id="commentForm">
        <form method="post" action="index.php?action=postPage&amp;chapterId=<?= $_GET['chapterId']; ?>&amp;chapterNb=<?= $_GET['chapterNb']; ?>">
            <p>
                <label for="pseudo">Pseudo: </label>
                <input type="text" name="pseudo" id="pseudo"/><br>
                <textarea cols="100" rows="10" name="comment"></textarea><br>
                <input class="button" type="submit" value="Commenter" name="commentButton"/>
            </p>
        </form>
    </div>
</section>

<script src="public/js/connect_form.js"></script>

<?php $blogContent = ob_get_clean();

require('view/template.php'); ?>