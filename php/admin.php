<?php 
// Connexion à la bdd
try {
    $bdd = new PDO('mysql:host=localhost;dbname=oc_p4;charset=utf8', 'root', '');
}
catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Admin</title>
        <link rel="stylesheet" media="screen" href="../css/admin.css">
    </head>
    
    <body>
        <!-- HEADER -->
        <header>
            <img id="montagnes_admin" src="../images/admin.png" alt="montagnes admin">
            <h1>Bienvenue <strong><?= $_POST['pseudo']?></strong></h1>
            <div id="menu_admin">
                <nav>
                    <ul>
                        <li>Mes billets</li>
                        <li>Brouillons</li>
                        <li>Écrire un nouveau billet</li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- NOUVEAU BILLETS -->
        <section id='newBillet'>
            <h2>Nouveau Billet</h2>
            <form method='post' action="new_billet.php">
            <label for="titre">Titre: </label><input type="text" name="titre" autofocus/><br>
            <label for="post_date">Date: </label><input type="date" name="post_date"/><br>
            <textarea name="contenu" id="newChapter" cols="137" rows="30"></textarea><br>
            <input type="button" value="Sauvegarder"/>
            <input type="submit" value="Publier"/>
            </form>
        </section>

        <!-- MES BILLETS -->
        <section id='new'>
            <h2>Mes BILLETS</h2>

        </section>
    </body>

    <!-- <script src=""></script> -->
</html>