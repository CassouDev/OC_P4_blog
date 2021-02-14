<?php 
// Connexion à la bdd
try {
    $bdd = new PDO('mysql:host=localhost;dbname=oc_p4;charset=utf8', 'root', '');
}
catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
}

//Démarrage de la session
session_start();
//Arrêt de la session + redirection
if(isset($_GET['deconnect'])) {
    session_destroy();
    header("Location:../index.php");
}

// Récupération des billets
$reponses = $bdd->query("SELECT id, titre, contenu, DATE_FORMAT(post_date, '%d/%m/%Y') AS post_date FROM billets ORDER BY post_date");
// Récupération des commentaires non signalés
$commentRep = $bdd->query("SELECT id, id_billet, auteur, commentaire, DATE_FORMAT(date_commentaire, '%d/%m/%Y') AS date_commentaire, sign_commentaire FROM commentaires WHERE sign_commentaire = '0' ORDER BY id DESC");
// Récupération des commentaires signalés
$reportComment = $bdd->query("SELECT * FROM commentaires WHERE sign_commentaire = '1' ORDER BY id DESC");

// Ajout d'un nouveau billet
if(isset($_POST['contenu'])) {
    $titre = $_POST['titre'];
    $post_date = $_POST['post_date'];
    $contenu = $_POST['contenu'];
    // Insertion du message à l'aide d'une requête préparée
    $req = $bdd->prepare('INSERT INTO billets (titre, post_date, contenu) VALUES(?, ?, ?)');
    $req->execute(array($titre, $post_date, $contenu));
}

// Suppression d'un billet
if(isset($_GET['supprBillet'])) {
    $suppr = $bdd->prepare('DELETE FROM billets WHERE id = :id');
    $suppr->execute([
        "id" => $_GET['idBillet']
    ]);
    ?>
<?php
}
//Désignaler un commentaire
if(isset($_GET['unreportComment'])) {
    $req = $bdd->prepare("UPDATE commentaires SET sign_commentaire = '0' WHERE id = :id");
    $req->execute([
        'id'=>$_GET['id']
    ]);
    ?>
    <?php
}
//Suppression d'un commentaire
if(isset($_GET['supprComment'])) {
    $suppr = $bdd->prepare('DELETE FROM commentaires WHERE id = :id');
    $suppr->execute([
        'id'=>$_GET['id']
    ]);
    ?>
    <?php
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Admin</title>
        <link rel="stylesheet" media="screen" href="../css/admin.css">
        <link rel="stylesheet" media="screen" href="../css/tabs.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    
    <body>
        <!-- HEADER -->
        <header>
            <a href="admin.php?deconnect" id="boutonDeconnect">Déconnexion</a>
            <img id="montagnes_admin" src="../images/admin.png" alt="montagnes admin">
        </header>

        <div id="bienvenue">
            <h1>Bienvenue <strong><?= $_SESSION['pseudo'] ?></strong></h1>
        </div>
        <div id="tabs">
            <div id="tabMenu">
                <div class="tab whiteborder">Nouveau billet</div>
                <div class="tab">Mes billets</div>
                <div class="tab">Commentaires</div>
            </div>

            <div class="tabContent">
                <div id="newBillet">
                    <form method='post' action="admin.php">
                    <label id="titreBillet" for="titre">Titre:</label><input id="inputTitre" type="text" name="titre" autofocus/><br>
                    <label id="dateBillet" for="post_date">Date:</label><input id="inputDate" type="date" name="post_date"/><br>
                    <textarea name="contenu" cols="70" rows="20"></textarea><br>
                    <input id="boutonPublier" type="submit" value="Publier"/>
                    </form>
                </div>
            </div>

            <div class="tabContent">
                <section id='sectionBillets'>
                    <!-- Récupération de tous les billets postés -->
                    <?php 
                    while($donnees = $reponses->fetch()) 
                    {
                    ?>
                        <a href="modification_billets.php?idBillet=<?= $donnees['id']; ?>">
                            <div class='derniersBillets'>
                                <h3><?= htmlspecialchars($donnees['titre']); ?></h3>
                            </div>
                        </a>
                    <?php
                    }
                    ?>
                </section>
            </div>

            <div class="tabContent">
                <section id='sectionCommentaires'>
                <!-- Récupération des commentaires signalés -->
                    <h1>Commentaires signalés</h1>
                    <div id="container">
                        <?php 
                        while($report = $reportComment->fetch()) {
                            ?>
                            <div id="signComment">
                                <div class="row">
                                    <div class="col">
                                        <p><strong><?= htmlspecialchars($report['auteur']); ?></strong> le <?= htmlspecialchars($report['date_commentaire']); ?></p>
                                    </div>
                                    <div class="col">
                                        <?php
                                        $req = $bdd->prepare("SELECT titre FROM billets WHERE id = :id");
                                        $req->execute([
                                            'id'=> $report['id_billet']
                                        ]);
                                        $title = $req->fetch();
                                        ?>
                                        <p><?= htmlspecialchars($title['titre']); ?></p>
                                    </div>
                                </div>
                                <p><?= htmlspecialchars($report['commentaire']); ?></p>
                                <div class="row">
                                    <div class="col">
                                        <a href="admin.php?unreportComment&amp;id=<?= $report['id']; ?>">Désignaler</a>
                                    </div>
                                    <div class="col">
                                        <a href="admin.php?supprComment&amp;id=<?= $report['id']; ?>">Supprimer</a>
                                    </div>

                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <h1>Autres commentaires</h1>
                    <!-- Récupération des commentaires non signalés -->
                    <div id="container">
                        <?php 
                        while($comments = $commentRep->fetch()) {
                        ?>  <div id="otherComment">
                                <div class="row">
                                    <div class="col">
                                        <p><strong><?= htmlspecialchars($comments['auteur']); ?></strong> le <?= htmlspecialchars($comments['date_commentaire']); ?></p>
                                    </div>
                                    <div class="col">
                                        <?php
                                        $req= $bdd->prepare('SELECT titre FROM billets WHERE id = :id');
                                        $req->execute([
                                            'id'=> $comments['id_billet']
                                        ]);
                                        $title = $req->fetch();
                                        ?>
                                        <p><?= htmlspecialchars($title['titre']); ?></p>
                                    </div>
                                </div>
                                <p><?= htmlspecialchars($comments['commentaire']); ?></p>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </section>
            </div>
        </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
    <script src="../js/tabs.js"></script>

    </body>
</html>