<?php
try 
{
    $db = new PDO('mysql:host=localhost;dbname=oc_p4;charset=utf8', 'root', '');
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}

function chargerClasse($classe)
{
  require '../model/' . $classe . '.php';
}

spl_autoload_register('chargerClasse'); // autoload register -> it can be called when we instantiate a undeclared class

$postManager = new PostManager($db);
// Get the post
$onePost = $postManager->getOnePost();

// Get the number of posts
$postsNumber = $postManager->countPosts();

$commentManager = new CommentManager($db);
// Get all the comments of this post
$comments = $commentManager->getOnePostComments();

// Get the number of comments
$commentsNumber = $commentManager->countComments();


// Access to the previous and next Chapter
$lastChapter = $postsNumber['postsNb'];
$prevChapter = $_GET['chapterNb'] - 1;
$nextChapter = $_GET['chapterNb'] + 1;

if(isset($_GET['previousChapter'])) 
{
    if($prevChapter > 0)
    {
        header("Location:../controller/postPage.php?chapterNb=$prevChapter");
    }else
    {
        header("Location:../controller/postPage.php?chapterNb=$lastChapter");
    }
}elseif (isset($_GET['nextChapter']))
{
    if($_GET['chapterNb'] < $lastChapter)
    {
        header("Location:../controller/postPage.php?chapterNb=$nextChapter");
    }else
    {
        header("Location:../controller/postPage.php?chapterNb=1");
    }
}

// Add a new comment (by the form)
if(isset($_POST['commentButton']) && isset($_POST['pseudo']) && isset($_POST['comment']))
{
    
    $newComment = new Comment([
        'postChapter' => $_GET['chapterNb'],
        'pseudo' => $_POST['pseudo'],
        'comment' => $_POST['comment']
    ]);
    
    if (empty($_POST['pseudo']) OR empty($_POST['comment']))
    {
        $message = "Veuillez remplir tous les champs svp.";
    }
    else
    {
        $commentManager->addComments($newComment);
        $message = 'Votre commentaire a bien été ajouté !';
    } 
}

// Report a comment
if (isset($_GET['reportComment']))
{
    $commentManager->reportTheComment();
    $message = 'Votre commentaire a bien été signalé !';
}

require('../view/frontend/postPageView.php');