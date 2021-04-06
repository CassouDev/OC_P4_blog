<?php
// Access to the classes
function loadClass($class)
{
  require 'model/' . $class . '.php';
}

spl_autoload_register('loadClass'); // autoload register -> it can be called when we instantiate a undeclared class


// Get posts
function homeGetPosts()
{
    $user = new UserManager();
    $pseudo = $user->getUserPseudo();

    $manager = new PostManager();
    $posts = $manager->getPost();

    //Start the session + redirection
    if (isset($_POST['password']) && isset($_POST['pseudo']))
    {
        $getPass = $user->getPassFromUser();

        $isPasswordCorrect = password_verify($_POST['password'], $getPass->pass());

        if ($isPasswordCorrect) 
        {
            $_SESSION['id'] = $getPass->id();
            $_SESSION['pseudo'] = $_POST['pseudo'];

            header("Location:index.php?action=admin");
        }
        else
        {
            throw new Exception('Mauvais identifiant ou mot de passe !');
        }
    }

    $manager = new PostManager();
    $posts = $manager->getPost();

    require('view/frontend/homepageView.php');
}

function postPage() 
{
    $postManager = new PostManager();
    // Get the post
    $onePost = $postManager->getOnePost();
    
    // Get the number of posts
    $postsNumber = $postManager->countPosts();

    $commentManager = new CommentManager();
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
            header("Location:index.php?action=postPage&chapterNb=$prevChapter");
        }else
        {
            header("Location:index.php?action=postPage&chapterNb=$lastChapter");
        }
    }elseif (isset($_GET['nextChapter']))
    {
        if($_GET['chapterNb'] < $lastChapter)
        {
            header("Location:index.php?action=postPage&chapterNb=$nextChapter");
        }else
        {
            header("Location:index.php?action=postPage&chapterNb=1");
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
            throw new Exception('Veuillez remplir tous les champs svp.');
        }
        else
        {
            $commentManager->addComments($newComment);
            throw new Exception('Votre commentaire a bien été ajouté !');
        } 
    }

    // Report a comment
    if (isset($_GET['reportComment']))
    {
        $commentManager->reportTheComment();
        throw new Exception('Votre commentaire a bien été signalé !');
    }

    require('view/frontend/postPageView.php');
}

function admin()
{
    //Stop the session + redirect
    if(isset($_GET['disconnect'])) 
    {
        session_destroy();
        header("Location:index.php");
    }

    $postManager = new PostManager();
    // Get posts
    $posts = $postManager->getPost();
    // Get the number of posts
    $lastChapter = $postManager->countPosts();
    $chapterNumber = $lastChapter['postsNb'] + 1;

    $adminCommentManager = new CommentManager();
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
            throw new Exception('Veuillez remplir tous les champs svp.');
            unset($newPost);
        }
        else
        {
            $postManager->addPosts($newPost);
            throw new Exception('Votre billet a bien été ajouté.');
        }
    }

    // Delete a post
    if(isset($_GET['deletePost'])) 
    {
        $postManager->deletePost();
        $postManager->deleteCommentFromPost();

        throw new Exception('Le billet a bien été supprimé !');
    }

    // Unreport a comment
    if(isset($_GET['unreportComment'])) 
    {
        $adminCommentManager->unreportTheComment();
        throw new Exception('Le commentaire a bien été désignalé !');
    }

    // Delete a comment
    if(isset($_GET['deleteComment'])) 
    {
        $adminCommentManager->deleteComment();
        throw new Exception('Le commentaire a bien été supprimé !');
    }

    require('view/backend/adminView.php');
}

function editPost()
{
    $postManager = new PostManager();
    // Get the post
    $onePost = $postManager->getOnePost();

    // edit the post
    if(isset($_POST['content'])) 
    {
        if($_POST['title'] != "" AND $_POST['content'] != "")
        {
            $postManager->editPost();
            throw new Exception('Le billet a bien été modifié !');
        }else 
        {
            throw new Exception('Veuillez remplir tous les champs svp.');
        }
    }

    require('view/backend/editPostView.php');
}