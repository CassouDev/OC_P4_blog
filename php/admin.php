<?php 
// Connexion à la bdd
try {
    $bdd = new PDO('mysql:host=localhost;dbname=oc_p4;charset=utf8', 'root', '');
}
catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
}
$reponses = $bdd->query('SELECT id, titre, contenu, DATE_FORMAT(post_date, \'%d/%m/%Y %Hh%imin%ss\') AS post_date FROM billets ORDER BY id DESC LIMIT 0,5');
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
            <img id="montagnes_admin" src="../images/admin.png" alt="montagnes admin">
            <h1>Bienvenue <strong><?= $_POST['pseudo']?></strong></h1>
        </header>

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
                    <!-- Récupération des 5 derniers billets postés -->
                    <?php 
                    while($donnees = $reponses->fetch()) {
                    ?>
                    <a href="php/billets.php?idBillet=<?php echo $donnees['id']; ?>">
                        <div class='derniersBillets'>
                            <h3><?php echo htmlspecialchars($donnees['titre'])?></h3>
                        </div>
                    </a>
                    <?php
                    }
                    $reponses->closeCursor();?>
                </section>
            </div>
        </div>
            
    </body>

    <script src="../js/tabs.js"></script>
</html>