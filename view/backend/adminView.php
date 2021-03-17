<?php
$blogTitle = "Admin";
$cssFile1 = "public/css/admin.css";
$cssFile2 = "public/css/popup.css";
$cssFile3 = null;
$headLink = null;
$imgId = "mountains_admin";
$scr = "public/images/admin.png";
$alt = "Mountains and'admin'";

ob_start(); ?>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!-- Tiny MCE -->
        <script src="https://cdn.tiny.cloud/1/aqri9stihbla01t0trc3y1ojilh9esu49i9gbdqx8y9ptule/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: '#mytextarea'
            });
        </script>
<?php $headContent = ob_get_clean();

ob_start(); ?>
<a href="index.php?action=admin&amp;disconnect" id="disconnectButton">Déconnexion</a>
<?php $headerButtons = ob_get_clean();

ob_start(); ?>
<div class="container adminContent">
    <div class="row text-center" id="welcome">
        <div class="col">
            <h1>Bienvenue <strong><?= $_SESSION['pseudo'] ?></strong></h1>
        </div>
    </div>
    <!-- PopUp messages -->
    <?php
    if (isset($message))
    {
    ?>
        <div class="popUp">
            <p><?= $message ?></p>
            <a href="index.php?action=admin" class="button">Ok</a>
        </div>
    <?php
    }
    ?>

    <nav class="row nav nav-tabs font-weight-bold text-center">
        <a class="col nav-item nav-link active" href="#newPost" data-toggle="tab"> Nouveau billet</a>
        <a class="col nav-item nav-link" href="#postSection" data-toggle="tab"> Mes billets</a>
        <a class="col nav-item nav-link" href="#commentSection" data-toggle="tab">Commentaires</a>
    </nav>

    <div class="row tab-content mb-5">
        <div class="col tab-pane active text-center mt-5 mb-4" id="newPost">
            <form method='post' action="index.php?action=admin">
                <p>
                    <label for="chapter">Chapitre:</label>
                    <input type="number" min="1" step="1"  id="inputChapter" value="<?= $chapterNumber; ?>" name="chapter"/><br>
                    <label for="title">Titre:</label>
                    <input type="text" id="inputTitle" name="title"/><br>
                    <textarea id="mytextarea" name="content" cols="70" rows="20"></textarea><br>
                    <input class="button" type="submit" value="Publier" name='publier'/>
                </p>
            </form>
        </div>

        <div class="col tab-pane text-center mt-5 mb-4" id="postSection">
            <!-- Display all the posted posts -->
            <?php 
            foreach($posts as $post) 
            {
            ?>
                <a href="index.php?action=editPost&amp;postId=<?= $post->id(); ?>&amp;chapterNb=<?= $post->chapter(); ?>">
                    <div class='lastPost text-center py-4 mx-auto mb-3'>
                        <h3>Chapitre <?= htmlspecialchars($post->chapter()) ?> - <?= htmlspecialchars($post->title()); ?></h3>
                    </div>
                </a>
            <?php
            }
            ?>
        </div>

        <div class="col tab-pane text-center mb-4" id="commentSection">
            <h1>Commentaires signalés</h1>
            <!-- Display the reported comments -->
            <div class="container px-0">
                <?php 
                foreach ($reportedComments as $reportedComment)
                {
                ?>
                    <div id="reportComment">
                        <div class="row">
                            <div class="col">
                                <p>
                                        
                                    <strong><?= htmlspecialchars($reportedComment->pseudo()); ?></strong> le <?= htmlspecialchars($reportedComment->commentDate()); ?>
                                </p>
                            </div>

                            <div class="col">
                                <?php
                                //Get titles of reported comments
                                $reportTitles = $postManager->getTitles($reportedComment->postChapter());

                                foreach ($reportTitles as $unreportTitle)
                                {
                                ?>
                                    <p>
                                    <strong>Chapitre <?= htmlspecialchars($reportedComment->postChapter()); ?></strong> - <?= htmlspecialchars($unreportTitle->title()); ?>
                                    </p>
                                <?php
                                }
                                ?>
                            </div>
                        </div>

                        <div class="row mx-0 px-4">
                            <p class="col px-4 mt-0 mb-3">
                                <?= htmlspecialchars($reportedComment->comment()); ?>
                            </p>
                        </div>

                        <div class="row">
                            <div class="col py-3">
                                <a class="button" href="index.php?action=admin&amp;unreportComment&amp;id=<?= $reportedComment->id(); ?>">Désignaler</a>
                            </div>

                            <div class="col py-3">
                                <a class="button" href="index.php?action=admin&amp;deleteComment&amp;id=<?= $reportedComment->id(); ?>">Supprimer</a>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>

            <h1 id="h1otherComments">Autres commentaires</h1>
            <!-- Display the unreported comments -->
            <div class="container px-0">
                <?php 
                foreach($unreportedComments as $unreportedComment) 
                {
                ?>  
                    <div id="unreportComment">
                        <div class="row mx-0 px-3">
                            <div class="col">
                                <p>
                                    <strong><?= htmlspecialchars($unreportedComment->pseudo()); ?></strong> le <?= htmlspecialchars($unreportedComment->commentDate()); ?>
                                </p>
                            </div>

                            <div class="col">
                                <?php
                                //Get titles of unreported comments
                                $unreportTitles = $postManager->getTitles($unreportedComment->postChapter());

                                foreach ($unreportTitles as $unreportTitle) 
                                {
                                ?>
                                    <p>
                                    <strong>Chapitre <?= htmlspecialchars($unreportedComment->postChapter()); ?></strong> - <?= htmlspecialchars($unreportTitle->title()); ?>
                                    </p>
                                <?php
                                }
                                ?>
                            </div>
                        </div>

                        <div class="row mx-0">
                            <p class="col px-4 mt-0 mb-3">
                                <?= htmlspecialchars($unreportedComment->comment()); ?>
                            </p>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<?php $blogContent = ob_get_clean();

require('view/template.php'); ?>