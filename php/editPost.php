<?php 
try
{
    $db = new PDO('mysql:host=localhost;dbname=oc_p4;charset=utf8', 'root', '');
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}
//Star the session
session_start();

function chargerClasse($classe)
{
  require $classe . '.php';
}

spl_autoload_register('chargerClasse');

$postManager = new PostManager($db);
// Get the post
$onePost = $postManager->getOnePost();

// edit the post
if(isset($_POST['content'])) 
{
    if($_POST['title'] != "" AND $_POST['content'] != "")
    {
        $postManager->editPost();
        $message = "Le billet a bien été modifié !";
    }else 
    {
        $message ="Veuillez remplir tous les champs svp.";
    }
}
 require('editPostView.php');