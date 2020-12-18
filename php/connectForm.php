<?php
    // Le mot de passe n'a pas été envoyé
    if (empty($_POST)) {

    // Le mot de passe n'est pas bon
    }elseif ($_POST['motdepasse'] != "1") { ?>
        <p>Le mot de passe est incorrect, veuillez retenter votre chance..</p>
        <button a href ="index.php"></button>
        
    <!-- Le mot de passe a été envoyé et il est bon -->
    <?php }else { 
        include("admin.php");
    } 
?>