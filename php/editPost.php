<?php 
try
{
    $db = new PDO('mysql:host=localhost;dbname=oc_p4;charset=utf8', 'root', '');
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}
//Star the session
session_start();

$req = $db->prepare("SELECT id, chapter, title, content, DATE_FORMAT(post_date, '%d/%m/%Y') AS post_date FROM posts WHERE id = :id");
$req->execute([
    'id'=> $_GET['postId']
]);

// edit the post
if(isset($_POST['content'])) {
    if($_POST['title'] != "" AND $_POST['content'] != "") {
        $title = $_POST['title'];
        $content = $_POST['content'];
            
        $req = $db->prepare('UPDATE posts SET title = :nwTitle, content = :nwContent WHERE id = :id');
        $req->execute(array(
            'nwTitle'=>$title, 
            'nwContent'=>$content, 
            'id'=> $_GET['postId']
        ));
        ?>
        <div class="popUp">
            <p>Le billet a bien été modifié !</p>
            <a href="admin.php" class="button">Ok</a>
        </div>
    <?php
    }else {
    ?>
        <div class="popUp">
            <p>Veuillez remplir tous les champs svp.</p>
            <a href="admin.php" class="button">Ok</a>
        </div>
    <?php 
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Modifier mon billet</title>
        <link rel="stylesheet" media="screen" href="../css/admin.css">
        <link rel="stylesheet" media="screen" href="../css/popup.css">
        <link rel="stylesheet" media="screen" href="../css/admin.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!-- Tiny MCE -->
        <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
        tinymce.init({
            selector: '#mytextarea'
        });
        </script>
    </head>

    <body>
        <!-- HEADER -->
        <header>
            <a href="admin.php?disconnect" id="disconnectButton">Déconnexion</a>
            <a href="admin.php" id="returnButton">Retour</a>
            <p>
                <img id="mountains_admin" src="../images/admin.png" alt="Mountains and 'admin'"/>
            </p>
        </header>

        <div class="container editPost text-center pt-5 pb-4">
            <h1>Modifier mon billet</h1>

            <div class="row mt-5">
                <?php 
                while($data = $req->fetch())
                {
                ?>
                    <form class="col" method='post' action="editPost.php?postId=<?= $data['id']; ?>">
                        <p>
                            <p>
                                <strong>Chapitre <?= $data['chapter'] ?></strong> - publié le <?= $data['post_date'] ?>
                            </p>
                            <label for="title">Titre:</label>
                            <input id="inputTitle" type="text" name="title" value="<?= $data['title']?>"/><br>
                            <textarea id="mytextarea" name="content" cols="70" rows="20"><?= $data['content']?></textarea><br>
                        
                            <div id="buttons">
                                <input class="button" type="submit" value="Modifier"/>
                                <a href="admin.php?chapterNb=<?= $_GET['chapterNb']; ?>&deletePost" class="button">Supprimer</a>
                            </div>
                        </p>
                    </form>
                <?php 
                }
                ?>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    </body>
</html>