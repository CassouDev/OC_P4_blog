<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Admin</title>
        <!-- <link rel="stylesheet" media="screen" href="css/accueil.css"> -->
    </head>
    
    <body>
        <!-- GEADER -->
        <header>
            <h1>admin <strong><?= $_POST['pseudo']?></strong></h1>
            <nav>
                <ul>
                    <li>Mes billets</li>
                    <li>Brouillons</li>
                    <li>Écrire un nouveau billet</li>
                </ul>
            </nav>
        </header>

        <!-- NOUVEAU BILLETS -->
        <section id='newBillet'>
            <h2>Nouveau Billet</h2>
            <form action="">
            <label for="titre">Titre: </label><input type="text" name="titre" autofocus/><br>
            <label for="date">Date: </label><input type="date" name="date"/><br>
            <textarea name="newChapter" id="newChapter" cols="150" rows="30"></textarea><br>
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