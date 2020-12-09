<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Billet simple pour l'Alaska</title>
        <link rel="stylesheet" media="screen" href="css/accueil.css">
    </head>
    
    <body>
        <button>acheter</button>
        <!-- MENU -->
        <header>
            <nav>
                <ul>
                    <li>Portrait</li>
                    <li><button id="boutonConnect">Connexion</button></li>
                </ul>
            </nav>
            <form method="post" action="php/connectForm.php" id="connectForm">
                    <label for="pseudo">Pseudo: </label><input type="pseudo" name="pseudo"/><br/>
                    <label for="motdepasse">Mot de passe: </label><input type="password" name="motdepasse"/><br/>
                    <input type="submit" value="Se connecter"/>
            </form>

        <!-- ENTETE GRAPHIQUE-->
            <section id='titre'>
                <h1>Billet simple pour l'Alaska</h1>
                <h2>par Jean Forteroche</h2>
            </section>
        </header>

        <!-- BILLETS -->
        <section id='sectionBillets'>
        </section>
    </body>

    <script src="js/connect.js"></script>
</html>