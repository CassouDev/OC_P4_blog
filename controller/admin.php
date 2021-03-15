<?php 
try 
{
    $db = new PDO('mysql:host=localhost;dbname=oc_p4;charset=utf8', 'root', '');
}
catch (Exception $e) 
{
    die('Erreur : ' . $e->getMessage());
}

//Start the session
session_start();
//Stop the session + redirect
if(isset($_GET['disconnect'])) {
    session_destroy();
    header("Location:../index.php");
}

function chargerClasse($classe)
{
  require '../model/' . $classe . '.php';
}

spl_autoload_register('chargerClasse'); // autoload register -> it can be called when we instantiate a undeclared class

$postManager = new PostManager($db);
// Get posts
$posts = $postManager->getPost();
// Get the number of posts
$lastChapter = $postManager->countPosts();
$chapterNumber = $lastChapter['postsNb'] + 1;

$adminCommentManager = new CommentManager($db);
// Get unreported comments
$unreportedComments = $adminCommentManager->getUnreportedComments();
// Get reported comments
$reportedComments = $adminCommentManager->getReportedComments();

// Add a new post
if(isset($_POST['publier']) && isset($_POST['chapter']) && isset($_POST['title']) && isset($_POST['content'])) 
{
    $newPost = new Post([
        'chapter' => $_POST['chapter'],
        'title' => $_POST['title'],
        'content' => $_POST['content']
    ]);

    if (!$newPost->validPost())
    {
        $message = "Veuillez remplir tous les champs svp.";
        unset($newPost);
    }
    else
    {
        $postManager->addPosts($newPost);
        $message = "Votre billet a bien été ajouté.";
    }
}

// Delete a post
if(isset($_GET['deletePost'])) 
{
    $postManager->deletePost();
    $postManager->deleteCommentFromPost();

    $message = 'Le billet a bien été supprimé !';
}

// Unreport a comment
if(isset($_GET['unreportComment'])) 
{
    $adminCommentManager->unreportTheComment();
    $message = 'Le commentaire a bien été désignalé !';
}

// Delete a comment
if(isset($_GET['deleteComment'])) 
{
    $adminCommentManager->deleteComment();
    $message ='Le commentaire a bien été supprimé !';
}

require('../view/backend/adminView.php');