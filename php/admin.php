<?php 
try 
{
    $db = new PDO('mysql:host=localhost;dbname=oc_p4;charset=utf8', 'root', '');
}
catch (Exception $e) 
{
    die('Erreur : ' . $e->getMessage());
}

//Start the session
session_start();
//Stop the session + redirect
if(isset($_GET['disconnect'])) {
    session_destroy();
    header("Location:../index.php");
}

// Get posts
$req = $db->query("SELECT id, chapter, title, content, DATE_FORMAT(post_date, '%d/%m/%Y') AS post_date FROM posts ORDER BY chapter DESC");
// Get unreported comments
$commentReq = $db->query("SELECT id, post_chapter, author, comment, DATE_FORMAT(comment_date, '%d/%m/%Y') AS comment_date, report_comment FROM comments WHERE report_comment = '0' ORDER BY post_chapter DESC");
// Get reported comments
$reportCommentReq = $db->query("SELECT * FROM comments WHERE  report_comment = '1' ORDER BY id DESC");

// Add a new post
if(isset($_POST['content'])) {
    $chapter = $_POST['chapter'];
    $title = $_POST['title'];
    $post_date = $_POST['post_date'];
    $content = $_POST['content'];
    // Inserting the message using a prepared query
    $insertReq = $db->prepare('INSERT INTO posts (chapter, title, post_date, content) VALUES(?, ?, ?, ?)');
    $insertReq->execute(array($chapter, $title, $post_date, $content));
    ?>
    <div class="popUp">
        <p>Le billet a bien été ajouté !</p>
        <a href="admin.php" class="button">Ok</a>
    </div>
<?php
}

// Delete a post
if(isset($_GET['supprBillet'])) {
    $delete = $db->prepare('DELETE FROM posts WHERE chapter = :chapter');
    $delete->execute([
        "chapter" => $_GET['chapter']
    ]);
    ?>
    <div class="popUp">
        <p>Le billet a bien été supprimé !</p>
        <a href="admin.php" class="button">Ok</a>
    </div>
<?php
}

// Unreport a comment
if(isset($_GET['unreportComment'])) {
    $req = $db->prepare("UPDATE comments SET report_comment = '0' WHERE id = :id");
    $req->execute([
        'id'=>$_GET['id']
    ]);
    ?>
    <div class="popUp">
        <p>Le commentaire a bien été désignalé !</p>
        <a href="admin.php" class="button">Ok</a>
    </div>
<?php
}

// Delete a comment
if(isset($_GET['deleteComment'])) {
    $suppr = $db->prepare('DELETE FROM comments WHERE id = :id');
    $suppr->execute([
        'id'=>$_GET['id']
    ]);
    ?>
    <div class="popUp">
        <p>Le commentaire a bien été supprimé !</p>
        <a href="admin.php" class="button">Ok</a>
    </div>
<?php
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" media="screen" href="../css/admin.css">
        <link rel="stylesheet" media="screen" href="../css/popup.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title>Admin</title>
    </head>
    
    <body>

        <!-- HEADER -->
        <header>
            <a href="admin.php?disconnect" id="disconnectButton">Déconnexion</a>
            <p>
                <img id="mountains_admin" src="../images/admin.png" alt="Mountains and'admin'"/>
            </p>
        </header>

        <div class="container adminContent">
            <div class="row text-center" id="welcome">
                <div class="col">
                    <h1>Bienvenue <strong><?= $_SESSION['pseudo'] ?></strong></h1>
                </div>
            </div>

            <nav class="row nav nav-tabs font-weight-bold text-center">
                <a class="col nav-item nav-link active" href="#newPost" data-toggle="tab"> Nouveau billet</a>
                <a class="col nav-item nav-link" href="#postSection" data-toggle="tab"> Mes billets</a>
                <a class="col nav-item nav-link" href="#commentSection" data-toggle="tab">Commentaires</a>
            </nav>

            <div class="row tab-content mb-5">
                <div class="col tab-pane active text-center mt-5 mb-4" id="newPost">
                    <form method='post' action="admin.php">
                        <p>
                            <label for="chapter">Chapitre:</label>
                            <input type="number" min="1" step="1" name="chapter" id="inputChapter"/><br>
                            <label for="title">Titre:</label>
                            <input type="text" name="title" id="inputTitle"/><br>
                            <label for="post_date">Date:</label>
                            <input type="date" name="post_date" id="inputDate"/><br>
                            <textarea name="content" cols="70" rows="20"></textarea><br>
                            <input class="button" type="submit" value="Publier"/>
                        </p>
                    </form>
                </div>

                <div class="col tab-pane text-center mt-5 mb-4" id="postSection">
                    <!-- Display all the posted posts -->
                    <?php 
                    while($data = $req->fetch()) 
                    {
                    ?>
                        <a href="editPost.php?postId=<?= $data['id'] ?>&amp;chapterNb=<?= $data['chapter']; ?>">
                            <div class='lastPost text-center py-4 mx-auto mb-3'>
                                <h3>Chapitre <?= htmlspecialchars($data['chapter'])?> - <?= htmlspecialchars($data['title']); ?></h3>
                            </div>
                        </a>
                    <?php
                    }
                    ?>
                </div>

                <div class="col tab-pane text-center mb-4" id="commentSection">
                    <h1>Commentaires signalés</h1>
                    <!-- Display the reported comments -->
                    <div class="container px-0">
                        <?php 
                        while($report = $reportCommentReq->fetch()) 
                        {
                        ?>
                            <div id="reportComment">
                                <div class="row">
                                    <div class="col">
                                        <p>
                                            <strong><?= htmlspecialchars($report['author']); ?></strong> le <?= htmlspecialchars($report['comment_date']); ?>
                                        </p>
                                    </div>

                                    <div class="col">
                                        <?php
                                        $req = $db->prepare("SELECT title FROM posts WHERE chapter = :chapter");
                                        $req->execute([
                                            'chapter'=> $report['post_chapter']
                                        ]);
                                        $title = $req->fetch();
                                        ?>
                                        <p>
                                            <?= htmlspecialchars($title['title']); ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="row mx-0 px-4">
                                    <p class="col px-4 mt-0 mb-3">
                                        <?= htmlspecialchars($report['comment']); ?>
                                    </p>
                                </div>

                                <div class="row">
                                    <div class="col py-3">
                                        <a class="button" href="admin.php?unreportComment&amp;id=<?= $report['id']; ?>">Désignaler</a>
                                    </div>

                                    <div class="col py-3">
                                        <a class="button" href="admin.php?deleteComment&amp;id=<?= $report['id']; ?>">Supprimer</a>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>

                    <h1 id="h1otherComments">Autres commentaires</h1>
                    <!-- Display the unreported comments -->
                    <div class="container px-0">
                        <?php 
                        while($comments = $commentReq->fetch()) 
                        {
                        ?>  
                            <div id="unreportComment">
                                <div class="row mx-0 px-3">
                                    <div class="col">
                                        <p>
                                            <strong><?= htmlspecialchars($comments['author']); ?></strong> le <?= htmlspecialchars($comments['comment_date']); ?>
                                        </p>
                                    </div>

                                    <div class="col">
                                        <?php
                                        $req= $db->prepare('SELECT title FROM posts WHERE chapter = :chapter');
                                        $req->execute([
                                            'chapter'=> $comments['post_chapter']
                                        ]);
                                        $title = $req->fetch();
                                        ?>
                                        <p>
                                        <strong>Chapitre <?= htmlspecialchars($comments['post_chapter'])?></strong> - <?= htmlspecialchars($title['title']); ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="row mx-0">
                                    <p class="col px-4 mt-0 mb-3">
                                        <?= htmlspecialchars($comments['comment']); ?>
                                    </p>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
    </body>
</html>