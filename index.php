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
        <link rel="stylesheet" media="screen" href="css/home_page.css">
    </head>
    
    <body>
        <!-- MENU -->
        <header>
            <button id="boutonConnect">Connexion</button>
            <div id="adminForm">
                <form method="post" action="php/connect_form.php" id="connectForm">
                    <p>
                        <label for="pseudo">Pseudo: </label>
                        <input type="text" name="pseudo"/><br>
                        <label for="motdepasse">Mot de passe: </label>
                        <input type="password" name="motdepasse"/><br>
                        <input class="button" type="submit" value="Se connecter"/>
                    </p>
                </form>
            </div>
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

    <script src="js/connect_form.js"></script>
</html>