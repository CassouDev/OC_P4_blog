<?php 
try {
    $db = new PDO('mysql:host=localhost;dbname=oc_p4;charset=utf8', 'root', '');
}
catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
}

//Start the session + redirection
if (isset($_GET['password']) && $_GET['password'] == '1') 
{
    session_start();
    $_SESSION['pseudo'] = $_GET['pseudo'];
    header("Location:php/admin.php");
}
else if (isset($_GET['password']) && $_GET['password'] != '1' ) 
{
    $message = "Le mot de passe est incorrect, veuillez retenter votre chance..";
?>
    <div class='popup'>
        <p>Le mot de passe est incorrect, veuillez retenter votre chance..</p>
        <a href="index.php" class="button">Retour</a>
    </div>
<?php
}else {

}

function chargerClasse($classe)
{
  require 'php/' . $classe . '.php';
}

spl_autoload_register('chargerClasse'); // autoload register -> it can be called when we instantiate a undeclared class
// Get posts
$manager = new PostManager($db);
$posts = $manager->getPost();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Billet simple pour l'Alaska</title>
        <link rel="stylesheet" media="screen" href="css/homepage.css">
        <link rel="stylesheet" media="screen" href="css/popup.css">
    </head>
    
    <body>
        <!-- MENU -->
        <header>
            <button id="connectButton">Connexion</button>
            <div id="adminForm">
                <form method="get" action="index.php" id="connectForm">
                    <p>
                        <label for='pseudo'>Pseudo: </label>
                        <input type='text' name='pseudo'/><br>
                        <label for='password'>Mot de passe: </label>
                        <input type='password' name='password'/><br>
                        <input class='button' type='submit' value="Se connecter"/>
                        <a href="index.php" class="button">Retour</a>
                    </p>
                </form>
            </div>
            <p>
                <img id="mountains" src="images/mountains.png" alt="Mountains and 'Billet simple pour l'Alaska'">
            </p>
        </header>

        <!-- POSTS -->
        <section id='postSection'>
            <!-- Get the posts -->
            <?php
            foreach ($posts as $post) 
            {
                ?>
                <a href="php/postPage.php?chapterNb=<?= $post->chapter(); ?>">
                <div class='lastPost'>
                    <h3>
                        Chapitre <?= htmlspecialchars($post->chapter()) ?> - <?= htmlspecialchars($post->title()) ?>
                    </h3>
                </div>
                </a>
            <?php
            }
            ?>
            

        </section>

        <script src="js/connect_form.js"></script>

    </body>
</html>