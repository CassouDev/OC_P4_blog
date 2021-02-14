<?php
// Connexion à la bdd
try {
    $bdd = new PDO('mysql:host=localhost;dbname=oc_p4;charset=utf8', 'root', '');
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Récupération du billet
$req = $bdd->prepare("SELECT id, titre, contenu, DATE_FORMAT(post_date, '%d/%m/%Y') AS post_date FROM billets WHERE id = :id");
$req->execute([
    "id"=> $_GET['idBillet']
]);

// Récupération des commentaires
$response = $bdd->prepare("SELECT id, id_billet, auteur, commentaire, DATE_FORMAT(date_commentaire, '%d/%m/%Y') AS date_commentaire, sign_commentaire FROM commentaires WHERE id_billet = ? AND sign_commentaire = '0' ORDER BY id DESC LIMIT 0,25");
$response->execute([
    $_GET['idBillet']
]);
    
// Gestion du formulaire d'ajout de commentaires
if(isset($_POST['commentaire'])) {
    $idBillet = $_GET['idBillet'];
    $auteur = $_POST['auteur'];
    $commentaire = $_POST['commentaire'];
    $date_commentaire = $_POST['date_commentaire'];
    $report = '0';
        
    $response = $bdd->prepare('INSERT INTO commentaires(id_billet, auteur, commentaire, date_commentaire, sign_commentaire) VALUES(:idbillet, :auteur, :comment, :commentdate, :report)');
    $response->execute(array(
        'idbillet' => $idBillet,
        'auteur' => $auteur,
        'comment' => $commentaire,
        'commentdate' => $date_commentaire,
        'report' => $report
    ));
    ?>
    <?php
}

// Signalement
if(isset($_GET['report_comment'])) {
    if($_GET['report_comment']='1') {
        $reportReq = $bdd->prepare('UPDATE commentaires SET sign_commentaire = 1 WHERE id = :id_comment');
        $reportReq->execute([
            'id_comment' => $_GET['id']
        ]);
    }
    ?>
    <?php
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Billet simple pour l'Alaska</title>
        <link rel="stylesheet" media="screen" href="../css/homepage.css">
        <link rel="stylesheet" media="screen" href="../css/billets.css">
    </head>
    <body>
        <!-- MENU -->
        <header>
            <button id="boutonConnect">Connexion</button>
            <div id="adminForm">
                <form method="get" action="../index.php" id="connectForm">
                    <p>
                        <label for="pseudo">Pseudo: </label>
                        <input type="text" name="pseudo"/><br>
                        <label for="motdepasse">Mot de passe: </label>
                        <input type="password" name="motdepasse"/><br>
                        <input class="button" type="submit" value="Se connecter"/>
                    </p>
                </form>
            </div>
            <p>
                <a href="../index.php">
                    <img id="montagnes" src="../images/montagnes.png" alt="montagnes billet simple pour l'Alaska">
                </a>
            </p>
            
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
            <h1 id="commentsTitle">Commentaires</h1>
            <!-- Récupération des commentaires -->
            <div id="comments">
                <?php while ($commentaires = $response->fetch()) { ?>
                        <div id="eachComment">
                            <p><strong> <?= htmlspecialchars($commentaires['auteur']) ?></strong> le <?= htmlspecialchars($commentaires['date_commentaire']) ?></p>
                            <p><?= htmlspecialchars($commentaires['commentaire']) ?></p>
                            <a href="billets.php?idBillet=<?= $_GET['idBillet'] ?>&amp;id=<?=$commentaires['id']?>&amp;report_comment=1" id="reportButton">Signaler</a>
                        </div>
                <?php } ?>
            </div>
            <!-- Formulaire d'ajout de commentaires -->
            <h1 id="letCommentsTitle">Laisser un commentaires</h1>
            <div id="commentForm">
                <form method="post" action="billets.php?idBillet=<?= $_GET['idBillet'] ?>">
                    <p>
                        <label for="auteur">Pseudo: </label>
                        <input id="auteur" type="text" name="auteur"/><br>
                        <label for="date_commentaire">Date: </label>
                        <input id="date_commentaire" type="date" name="date_commentaire"/><br>
                        <textarea name="commentaire" cols="100" rows="10"></textarea><br>
                        <input class="button" type="submit" name="boutonCommenter" value="Commenter"/>
                    </p>
                </form>
            </div>
        </section>
        <script src="../js/connect_form.js"></script>

    </body>
</html>
