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
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Admin</title>
        <link rel="stylesheet" media="screen" href="../css/admin.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
        <div class="container">
            <div class="row" id='newTitle'>
                <h2>Nouveau Billet</h2>
            </div>
            <div class="row" id='newBillet'>
                <form method='post' action="new_billet.php">
                <label for="titre">Titre: </label><input type="text" name="titre" autofocus/><br>
                <label for="post_date">Date: </label><input type="date" name="post_date"/><br>
                <textarea name="contenu" id="newChapter" cols="137" rows="30"></textarea><br>
                <input type="button" value="Sauvegarder"/>
                <input type="submit" value="Publier"/>
                </form>
            </div>
        </div>

            <!-- MES BILLETS -->
            <section id='new'>
                <h2>Mes BILLETS</h2>
            </section>
        </div>

    <!-- Optional JavaScript -->

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
       
    </body>

    <!-- <script src=""></script> -->
</html>