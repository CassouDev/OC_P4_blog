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
    header("Location:controller/admin.php");
}
else if (isset($_GET['password']) && $_GET['password'] != '1' ) 
{
    $message = "Le mot de passe est incorrect, veuillez retenter votre chance..";
}else {

}

function chargerClasse($classe)
{
  require 'model/' . $classe . '.php';
}

spl_autoload_register('chargerClasse'); // autoload register -> it can be called when we instantiate a undeclared class
// Get posts
$manager = new PostManager($db);
$posts = $manager->getPost();

require('view/frontend/homepageView.php');