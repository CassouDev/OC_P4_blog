<?php
try 
{
    $db = new PDO('mysql:host=localhost;dbname=oc_p4;charset=utf8', 'root', '');
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}

function chargerClasse($classe)
{
  require $classe . '.php';
}

spl_autoload_register('chargerClasse'); // autoload register -> it can be called when we instantiate a undeclared class

$postsManager = new PostsManager($db);
// Get the post
$onePost = $postsManager->getOnePost();

// Get the number of posts
$postsNumber = $postsManager->countPosts();

$commentsManager = new CommentsManager($db);
// Get all the comments of this post
$comments = $commentsManager->getComments();

// Get the number of comments
$commentsNumber = $commentsManager->countComments();

// Access to the previous and next Chapter
$lastChapter = $postsNumber['postsNb'];
$prevChapter = $_GET['chapterNb'] - 1;
$nextChapter = $_GET['chapterNb'] + 1;

if(isset($_GET['previousChapter'])) 
{
    if($prevChapter > 0)
    {
        header("Location:post.php?chapterNb=$prevChapter");
    }else
    {
        header("Location:post.php?chapterNb=$lastChapter");
    }
}elseif (isset($_GET['nextChapter']))
{
    if($_GET['chapterNb'] < $lastChapter)
    {
        header("Location:post.php?chapterNb=$nextChapter");
    }else
    {
        header("Location:post.php?chapterNb=1");
    }
}

// Add a comment (by the form)
if(isset($_POST['commentButton']) && isset($_POST['pseudo'])) 
{
    $addComment = $commentsManager->addComments();
    ?>
    <div class="popUp">
        <p>Votre commentaire a bien été ajouté !</p>
        <a href="post.php?chapterNb=<?= $_GET['chapterNb']; ?>" class="button">Ok</a>
    </div>
<?php
}

// Report a comment
if(isset($_GET['reportComment'])) 
{
    $reportComment = $commentsManager->reportComments();
    ?>
    <div class="popUp">
        <p>Le commentaire a bien été signalé !</p>
        <a href="post.php?chapterNb=<?= $_GET['chapterNb']; ?>" class="button">Ok</a>
    </div>
<?php
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Billet simple pour l'Alaska</title>
        <link rel="stylesheet" media="screen" href="../css/homepage.css">
        <link rel="stylesheet" media="screen" href="../css/post.css">
        <link rel="stylesheet" media="screen" href="../css/popup.css">
        <script src="https://kit.fontawesome.com/1d97b80b9e.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <!-- MENU -->
        <header>
            <button id="connectButton">Connexion</button>
            <a href="../index.php" scr="Bouton de retour à l'accueil" id="returnButton">Accueil</a>

            <div id="adminForm">
                <form method="get" action="../index.php" id="connectForm">
                    <p>
                        <label for="pseudo">Pseudo: </label>
                        <input type="text" name="pseudo"/><br>
                        <label for="password">Mot de passe: </label>
                        <input type="password" name="password"/><br>
                        <input class="button" type="submit" value="Se connecter"/>
                        <a href="post.php?chapterNb=<?= $_GET['chapterNb']; ?>" class="button">Retour</a>
                    </p>
                </form>
            </div>

            <p>
                <a href="../index.php">
                    <p>
                        <img id="mountains" src="../images/mountains.png" alt="Mountains and 'Billet simple pour l'Alaska'"/>
                    </p>
                </a>
            </p>
        </header>

        <!-- Display a post -->
        <section id='postSection'>
            <?php 
            foreach ($onePost as $post) 
            {
            ?>
                <h1>
                    <a href="post.php?chapterNb=<?= $_GET['chapterNb'] ?>&amp;previousChapter">
                        <span style="font-size: 58px; color: white;">
                            <i class="fas fa-caret-left" alt="Simple white arrow to the previous chapter"></i>
                        </span>
                    </a>
                    <p>
                        Chapitre <?= $_GET['chapterNb'] ?> - <?= htmlspecialchars($post->title())?>
                    </p>
                    <a href="post.php?chapterNb=<?= $_GET['chapterNb'] ?>&amp;nextChapter">
                        <span style="font-size: 58px; color: white;">
                            <i class="fas fa-caret-right" alt="Simple white arrow to the next chapter"></i>
                        </span>
                    </a>
                </h1>
                <h2><?= htmlspecialchars($post->postDate()) ?></h2>
                <p><?= ($post->content()) ?></p>
            <?php
            }
            ?>
        </section>

        <section id='commentSection'>
            <h1 id="commentsTitle">Commentaires (<?= $commentsNumber ?>)</h1>
            <!-- Display comments -->
            <div id="comments">
                <?php 
                foreach ($comments as $comment) {
                ?>
                    <div id="eachComment">
                        <p><strong> <?= htmlspecialchars($comment->pseudo()) ?></strong> le <?= htmlspecialchars($comment->commentDate()) ?></p>
                        <p><?= htmlspecialchars($comment->comment()) ?></p>
                        <a href="post.php?chapterNb=<?= $_GET['chapterNb'] ?>&amp;id=<?= $comment->id() ?>&amp;reportComment" id="reportButton">Signaler</a>
                    </div>
                <?php 
                } 
                ?>
            </div>

            <!-- Adding comments form -->
            <h1 id="letComment">Laisser un commentaire</h1>

            <div id="commentForm">
                <form method="post" action="post.php?chapterNb=<?= $_GET['chapterNb'] ?>">
                    <p>
                        <label for="pseudo">Pseudo: </label>
                        <input type="text" name="pseudo"/><br>
                        <textarea name="comment" cols="100" rows="10"></textarea><br>
                        <input class="button" type="submit" value="Commenter" name="commentButton"/>
                    </p>
                </form>
            </div>
        </section>

        <script src="../js/connect_form.js"></script>
    </body>
</html>
