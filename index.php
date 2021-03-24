<?php
session_start();
require('controller/controller.php');

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'homeGetPosts')
    {
        homeGetPosts();
    }
    elseif ($_GET['action'] == 'postPage')
    {
        if (isset($_GET['chapterNb']) && $_GET['chapterNb'] > 0)
        {
            postPage();
        }
        elseif (isset($_GET['chapterNb']) && $_GET['chapterNb'] < 0)
        {
            postPage();
        }
        else
        {
            echo 'Erreur : aucun identifiant de billet envoyé';
        }
    }
    elseif ($_GET['action'] == 'admin')
    {
        admin();
    }
    elseif ($_GET['action'] == 'editPost')
    {
        if (isset($_GET['chapterNb']) && $_GET['chapterNb'] > 0)
        {
            editPost();
        }else
        {
            echo 'Erreur : aucun identifiant de billet envoyé';
        }
    }
}
else 
{
    homeGetPosts();
}