<?php
$headerButtons = null;
$imgId = "mountains";
$scr = "public/images/mountains.png";
$alt = "Mountains";

if(isset($_GET['action'])) {
    $action = $_GET['action'];
}
else {
    $action = "homeGetPosts";
}

if(isset($_GET['chapterId'])) {
    $chapterID = $_GET['chapterId'];
}
else {
    $chapterID = null;
}

if(isset($_GET['chapterNb'])) {
    $chapterNB = $_GET['chapterNb'];
}
else {
    $chapterNB = null;
}

if(isset($_GET['id'])) {
    $id = $_GET['id'];
}
else {
    $id = null;
}

if(isset($_GET['deletePost'])) {
    $delete = 'deletePost';
}
else {
    $delete = null;
}

ob_start(); ?>
    <link rel="stylesheet" media="screen" href="public/css/homepage.css"/>
    <link rel="stylesheet" media="screen" href="public/css/popup.css"/>
<?php $headContent = ob_get_clean();

ob_start(); ?>
    <!-- PopUp messages -->
    <?php
    if (isset($message))
    {
    ?>
        <div class="popUp">
            <p><?= $message ?></p>
            
            <a href="index.php?action=<?= $action; ?>&amp;chapterId=<?= $chapterID; ?>&amp;chapterNb=<?= $chapterNB; ?>&amp;id=<?= $id; ?>" class="button">Ok</a>
        </div>
    <?php
    }
    ?>
<?php $blogContent = ob_get_clean();

require('view/template.php'); ?>