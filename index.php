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
        <title>Billet simple pour l'Alaska</title>
        <link rel="stylesheet" media="screen" href="css/accueil.css">
    </head>
    
    <body>
        <!-- MENU -->
        <header>
            <?php include("php/connect.php"); ?>
            <img id="montagnes" src="images/montagnes.png" alt="montagnes billet simple pour l'Alaska">
        </header>

        <!-- BILLETS -->
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
    </body>

    <script src="js/connect.js"></script>
</html>