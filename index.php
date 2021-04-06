<?php
session_start();
require('controller/controller.php');

try
{
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'homeGetPosts')
        {
            homeGetPosts();
        }
        elseif ($_GET['action'] == 'postPage')
        {
            if (isset($_GET['chapterId']) && $_GET['chapterId'] > 0)
            {
                postPage();
            }
            elseif (isset($_GET['chapterId']) && $_GET['chapterId'] < 0)
            {
                postPage();
            }
            else
            {
                throw new Exception('Erreur : aucun identifiant de billet envoyé');
            }
        }
        elseif ($_GET['action'] == 'admin')
        {
            admin();
        }
        elseif ($_GET['action'] == 'editPost')
        {
            if (isset($_GET['chapterId']) && $_GET['chapterId'] > 0)
            {
                editPost();
            }
            else
            {
                throw new Exception('Erreur : aucun identifiant de billet envoyé');
            }
        }
    }
    else 
    {
        homeGetPosts();
    }
}
catch(Exception $e) // if there is an error message
{ 
    $message = $e->getMessage();
    require('view/errorView.php');
}