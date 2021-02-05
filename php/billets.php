<?php
    // Connexion à la bdd
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=oc_p4;charset=utf8', 'root', '');
    }
    catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
    }

    // Récupération du billet
    $req = $bdd->prepare("SELECT id, titre, contenu, DATE_FORMAT(post_date, '%d/%m/%Y %Hh%imin%ss') AS post_date FROM billets WHERE id = :id");
    $req->execute([
        "id"=> $_GET['idBillet']
    ]);
    
    // // Récupération des commentaires
    // $response = $bdd->prepare('SELECT id, id_billet, auteur, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y %Hh%imin%ss\') AS date_commentaire FROM commentaires WHERE id_billet = ? ORDER BY id LIMIT 0,25');
    // $response->execute(array($_GET['billet']));
    
    // Gestion du formulaire ici
    if(isset($_POST['commentaire'])) {
        var_dump ('envoyer');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Billet simple pour l'Alaska</title>
        <link rel="stylesheet" media="screen" href="../css/home_page.css">
        <link rel="stylesheet" media="screen" href="../css/billets.css">
    </head>
    <body>
        <!-- MENU -->
        <header>
            <?php include("connect.php"); ?>
            <img id="montagnes" src="../images/montagnes.png" alt="montagnes billet simple pour l'Alaska">
        </header>
        <!-- Récupération du billet -->
        <section id='sectionBillet'>
            <?php 
            while($articles = $req->fetch()) {
            ?>
            <h1><?php echo htmlspecialchars($articles['titre']) ?></h1>
            <h2><?php echo htmlspecialchars($articles['post_date']) ?></h2>
            <p><?php echo htmlspecialchars($articles['contenu']) ?></p>
            <?php
            }
            $req->closeCursor();?>
        </section>
        <section id='sectionCommentaires'>
            <h1>Commentaires</h1>
            <!-- Récupération des commentaires -->
            <?php while ($commentaires = $req->fetch()) { ?>
                    <p><strong> <?= htmlspecialchars($commentaires['auteur']) ?></strong> le <?= htmlspecialchars($commentaires['date_commentaire']) ?></p>';
                    <p><?= htmlspecialchars($commentaires['commentaire']) ?></p>';
            <?php } ?>
            <div id="commentForm">
                        <form method="post" id="commentForm">
                        <label for="comment_titre">Titre: </label><input type="text" name="comment_titre" autofocus/><br>
                        <label for="comment_date">Date: </label><input type="date" name="comment_date"/><br>
                        <textarea name="commentaire" id="newComment" cols="100" rows="10"></textarea><br>
                            <input type="submit" name="commentaire" value="Commenter"/>
                        </form>
            </div>
        </section>
    </body>
    <script src="../js/connect_form.js"></script>
</html>
