<?php
try 
{
    $db = new PDO('mysql:host=localhost;dbname=oc_p4;charset=utf8', 'root', '');
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}

// Get the post
$req = $db->prepare("SELECT id, chapter, title, content, DATE_FORMAT(post_date, '%d/%m/%Y') AS post_date FROM posts WHERE chapter = :chapter");
$req->execute([
    "chapter"=> $_GET['chapterNb']
]);

// Get all the comments of this post
$commentReq = $db->prepare("SELECT id, post_chapter, author, comment, DATE_FORMAT(comment_date, '%d/%m/%Y') AS comment_date, report_comment FROM comments WHERE post_chapter = ? AND report_comment = '0' ORDER BY id DESC");
$commentReq->execute([
    $_GET['chapterNb']
]);

// Get the number of comments
$commentsNb = $db->prepare("SELECT COUNT(*) AS comment_nb FROM comments WHERE post_chapter = ? AND report_comment = '0'");
$commentsNb->execute([
    $_GET['chapterNb']
]);
$number = $commentsNb->fetch();

// Access to the previous and next Chapter
$lastChapter = $number['comment_nb'];
if(isset($_GET['previousChapter'])) 
{
    $prevChapter = $_GET['chapterNb'] - 1;
    if($prevChapter > 0)
    {
        header("Location:post.php?chapterNb=$prevChapter");
    }else
    {
        header("Location:post.php?chapterNb=$lastChapter");
    }
}elseif (isset($_GET['nextChapter']))
{
    $nextChapter = $_GET['chapterNb'] + 1;
    if($_GET['chapterNb'] < $lastChapter)
    {
        header("Location:post.php?chapterNb=$nextChapter");
    }else
    {
        header("Location:post.php?chapterNb=1");
    }
}

// Management of the adding comments form
if(isset($_POST['comment'])) {
    $postChapter = $_GET['chapterNb'];
    $author = $_POST['author'];
    $comment = $_POST['comment'];
    $report = '0';
        
    $commentReq = $db->prepare('INSERT INTO comments(post_chapter, author, comment, comment_date, report_comment) VALUES(:postChapter, :author, :comment, NOW(), :report)');
    $commentReq->execute(array(
        'postChapter' => $postChapter,
        'author' => $author,
        'comment' => $comment,
        'report' => $report
    ));
    ?>
    <div class="popUp">
        <p>Votre commentaire a bien été ajouté !</p>
        <a href="post.php?chapterNb=<?= $_GET['chapterNb']; ?>" class="button">Ok</a>
    </div>
<?php
}

// Reporting a comment
if(isset($_GET['reportComment'])) {
    $reportReq = $db->prepare('UPDATE comments SET report_comment = 1 WHERE id = :commentId');
    $reportReq->execute([
        'commentId' => $_GET['id']
    ]);
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
            while($post = $req->fetch()) 
            {
            ?>
                <h1>
                    <a href="post.php?chapterNb=<?= $_GET['chapterNb'] ?>&amp;previousChapter">
                        <p>
                            <img src="../images/simple_white_arrow_left.png" alt="Simple white arrow to the previous chapter">
                        </p>
                    </a>
                    <p>
                        Chapitre <?= $_GET['chapterNb'] ?> - <?= htmlspecialchars($post['title'])?>
                    </p>
                    <a href="post.php?chapterNb=<?= $_GET['chapterNb'] ?>&amp;nextChapter">
                        <p>
                            <img src="../images/simple_white_arrow_right.png" alt="Simple white arrow to the next chapter">
                        </p>
                    </a>
                </h1>
                <h2><?= htmlspecialchars($post['post_date']) ?></h2>
                <p><?= htmlspecialchars($post['content']) ?></p>
            <?php
            }
            ?>
        </section>

        <section id='commentSection'>
            <h1 id="commentsTitle">Commentaires (<?= $number['comment_nb'] ?>)</h1>
            <!-- Display comments -->
            <div id="comments">
                <?php 
                while ($comments = $commentReq->fetch()) 
                { 
                ?>
                    <div id="eachComment">
                        <p><strong> <?= htmlspecialchars($comments['author']) ?></strong> le <?= htmlspecialchars($comments['comment_date']) ?></p>
                        <p><?= htmlspecialchars($comments['comment']) ?></p>
                        <a href="post.php?chapterNb=<?= $_GET['chapterNb'] ?>&amp;id=<?= $comments['id'] ?>&amp;reportComment" id="reportButton">Signaler</a>
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
                        <label for="author">Pseudo: </label>
                        <input type="text" name="author"/><br>
                        <label for="commentDate">Date: </label>
                        <textarea name="comment" cols="100" rows="10"></textarea><br>
                        <input class="button" type="submit" name="commentButton" value="Commenter"/>
                    </p>
                </form>
            </div>
        </section>

        <script src="../js/connect_form.js"></script>
    </body>
</html>
