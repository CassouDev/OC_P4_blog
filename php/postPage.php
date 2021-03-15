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

$postManager = new PostManager($db);
// Get the post
$onePost = $postManager->getOnePost();

// Get the number of posts
$postsNumber = $postManager->countPosts();

$commentManager = new CommentManager($db);
// Get all the comments of this post
$comments = $commentManager->getOnePostComments();

// Get the number of comments
$commentsNumber = $commentManager->countComments();


// Access to the previous and next Chapter
$lastChapter = $postsNumber['postsNb'];
$prevChapter = $_GET['chapterNb'] - 1;
$nextChapter = $_GET['chapterNb'] + 1;

if(isset($_GET['previousChapter'])) 
{
    if($prevChapter > 0)
    {
        header("Location:postPage.php?chapterNb=$prevChapter");
    }else
    {
        header("Location:postPage.php?chapterNb=$lastChapter");
    }
}elseif (isset($_GET['nextChapter']))
{
    if($_GET['chapterNb'] < $lastChapter)
    {
        header("Location:postPage.php?chapterNb=$nextChapter");
    }else
    {
        header("Location:postPage.php?chapterNb=1");
    }
}

// Add a new comment (by the form)
if(isset($_POST['commentButton']) && isset($_POST['pseudo']) && isset($_POST['comment']))
{
    
    $newComment = new Comment([
        'postChapter' => $_GET['chapterNb'],
        'pseudo' => $_POST['pseudo'],
        'comment' => $_POST['comment']
    ]);
    
    if (empty($_POST['pseudo']) OR empty($_POST['comment']))
    {
        $message = "Veuillez remplir tous les champs svp.";
    }
    else
    {
        $commentManager->addComments($newComment);
        $message = 'Votre commentaire a bien été ajouté !';
    } 
}

// Report a comment
if (isset($_GET['reportComment']))
{
    $commentManager->reportTheComment();
    $message = 'Votre commentaire a bien été signalé !';
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
                        <a href="postPage.php?chapterNb=<?= $_GET['chapterNb']; ?>" class="button">Retour</a>
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
            <!-- PopUp messages -->
            <?php
            if (isset($message))
            {
            ?>
                <div class="popUp">
                    <p><?= $message ?></p>
                    <a href="postPage.php?chapterNb=<?= $_GET['chapterNb']; ?>" class="button">Ok</a>
                </div>
            <?php
            }

            foreach ($onePost as $post) 
            {
            ?>
                <h1>
                    <a href="postPage.php?chapterNb=<?= $_GET['chapterNb'] ?>&amp;previousChapter">
                        <span style="font-size: 58px; color: white;">
                            <i class="fas fa-caret-left" alt="Simple white arrow to the previous chapter"></i>
                        </span>
                    </a>
                    <p>
                        Chapitre <?= $_GET['chapterNb'] ?> - <?= htmlspecialchars($post->title())?>
                    </p>
                    <a href="postPage.php?chapterNb=<?= $_GET['chapterNb'] ?>&amp;nextChapter">
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
                        <a href="postPage.php?chapterNb=<?= $_GET['chapterNb'] ?>&amp;id=<?= $comment->id() ?>&amp;reportComment" id="reportButton">Signaler</a>
                    </div>
                <?php 
                } 
                ?>
            </div>

            <!-- Adding comments form -->
            <h1 id="letComment">Laisser un commentaire</h1>

            <div id="commentForm">
                <form method="post" action="postPage.php?chapterNb=<?= $_GET['chapterNb'] ?>">
                    <p>
                        <label for="pseudo">Pseudo: </label>
                        <input type="text" name="pseudo"/><br>
                        <textarea cols="100" rows="10" name="comment"></textarea><br>
                        <input class="button" type="submit" value="Commenter" name="commentButton"/>
                    </p>
                </form>
            </div>
        </section>

        <script src="../js/connect_form.js"></script>
    </body>
</html>
