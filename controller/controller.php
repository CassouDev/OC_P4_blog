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

    //Add a new user
    if(isset($_POST['userPseudo']) && isset($_POST['pass'])) 
    {
        $pass_hache = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        $newUser = new User([
            'userPseudo' => $_POST['userPseudo'],
            'pass' => $pass_hache
        ]);

        if (empty($newUser))
        {
            $message = "Veuillez remplir tous les champs svp.";
            unset($newUser);
        }
        else
        {
            $User->addUser($newUser);
            $message = "Votre compte a bien été enregistré.";
        }
    }

    //Start the session + redirection
    if (isset($_POST['password']) && isset($_POST['pseudo']))
    {
        $pseudo = $_POST['pseudo'];
        $getConnect = $user->getPassFromUser($pseudo);
        $isPasswordCorrect = password_verify($_POST['password'] == $getConnect);

        if ($isPasswordCorrect) {
            session_start();
            $_SESSION['id'] = $passFromUser['id'];
            $_SESSION['userPseudo'] = $_GET['pseudo'];
            header("Location:index.php?action=admin");
        }
        else
        {
            $message = 'Mauvais identifiant ou mot de passe !';
        }
    }
    

    // //Start the session + redirection
    // if (isset($_GET['password']) && $_GET['password'] == '1') 
    // {
    //     session_start();
    //     $_SESSION['pseudo'] = $_GET['pseudo'];
    //     header("Location:index.php?action=admin");
    // }
    // else if (isset($_GET['password']) && $_GET['password'] != '1' ) 
    // {
    //     $message = "Le mot de passe est incorrect, veuillez retenter votre chance..";
    // }

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

    require('view/frontend/postPageView.php');
}

function admin()
{
    //Start the session
    session_start();
    //Stop the session + redirect
    if(isset($_GET['disconnect'])) {
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

    require('view/backend/adminView.php');
}

function editPost()
{
    //Star the session
    session_start();

    $postManager = new PostManager();
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
    require('view/backend/editPostView.php');
}