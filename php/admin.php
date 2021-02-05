<?php 
// Connexion à la bdd
try {
    $bdd = new PDO('mysql:host=localhost;dbname=oc_p4;charset=utf8', 'root', '');
}
catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
}
// Récupération des billets
$reponses = $bdd->query("SELECT id, titre, contenu, DATE_FORMAT(post_date, '%d/%m/%Y %Hh%imin%ss') AS post_date FROM billets ORDER BY id DESC LIMIT 0,10");
// Ajout des nouveaux billets
if(isset($_POST['contenu'])) {
    $titre = $_POST['titre'];
    $post_date = $_POST['post_date'];
    $contenu = $_POST['contenu'];
    // Insertion du message à l'aide d'une requête préparée
    $req = $bdd->prepare('INSERT INTO billets (titre, post_date, contenu) VALUES(?, ?, ?)');
    $req->execute(array($titre, $post_date, $contenu));
}

// Suppression des billets
if(isset($_GET['supprBillet']) & $_GET['supprBillet'] = '1') {
    $suppr = $bdd->prepare('DELETE FROM billets WHERE id = :id');
    $suppr->execute([
        "id"=> $_GET['idBillet']
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
            <button id="boutonDeconnect">Déconnexion</button>
            <img id="montagnes_admin" src="../images/admin.png" alt="montagnes admin">
        </header>

        <div id="bienvenue">
            <h1>Bienvenue <strong>
                <!-- <?=$_POST['pseudo'], $_GET['pseudo']?> -->
                Jean Forteroche</strong></h1>
        </div>
        <div id="tabs">
            <div id="tabMenu">
                <div class="tab whiteborder">Nouveau billet</div>
                <div class="tab">Mes billets</div>
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
                    <!-- Récupération des 10 derniers billets postés -->
                    <?php 
                    while($donnees = $reponses->fetch()) 
                    {
                        var_dump($donnees['titre']);
                        ?>
                        <a href="modification_billets.php?idBillet=<?= $donnees['id']; ?>">
                            <div class='derniersBillets'>
                                <h3><?= htmlspecialchars($donnees['titre']); ?></h3>
                            </div>
                        </a>
                    <?php
                    }
                    $reponses->closeCursor();
                    ?>
                </section>
            </div>

        </div>
            
    </body>

    <script src="../js/tabs.js"></script>
</html>