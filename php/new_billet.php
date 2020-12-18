<?php 
// Connexion à la bdd
try {
    $bdd = new PDO('mysql:host=localhost;dbname=oc_p4;charset=utf8', 'root', '');
}
catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
}

// Insertion du message à l'aide d'une requête préparée
$titre = $_POST['titre'];
$post_date = $_POST['post_date'];
$contenu = $_POST['contenu'];
    
$req = $bdd->prepare('INSERT INTO billets (titre, post_date, contenu) VALUES(?, ?, ?)');
$req->execute(array($titre, $post_date, $contenu));
?>