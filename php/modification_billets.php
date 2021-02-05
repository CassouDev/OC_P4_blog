<?php 
// Connexion à la bdd
try {
    $bdd = new PDO('mysql:host=localhost;dbname=oc_p4;charset=utf8', 'root', '');
}
catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
}

$response = $bdd->prepare("SELECT id, titre, contenu, DATE_FORMAT(post_date, '%Y-%m-%d') AS post_date FROM billets WHERE id = :id");
$response->execute([
    "id"=> $_GET['idBillet']
]);

// Modification du billet
if(isset($_POST['contenu'])) {
    $titre = $_POST['titre'];
    $post_date = $_POST['post_date'];
    $contenu = $_POST['contenu'];
    // Modification du message à l'aide d'une requête préparée
    $req = $bdd->prepare('UPDATE billets SET titre = :nvtitre, post_date = :nvpost_date, contenu = :nvcontenu WHERE id = :id');
    $req->execute(array(
        'nvtitre'=>$titre, 
        'nvpost_date'=>$post_date,
        'nvcontenu'=>$contenu, 
        'id'=> $_GET['idBillet']
    ));
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Modifier mon billet</title>
        <link rel="stylesheet" media="screen" href="../css/admin.css">
        <link rel="stylesheet" media="screen" href="../css/tabs.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>

    <body>
        <!-- HEADER -->
        <header>
            <img id="montagnes_admin" src="../images/admin.png" alt="montagnes admin">
        </header>

        <div id="modifierBillet">
            <h1>Modifier mon billet</h1>
            <div id="formModif">
                <?php 
                while($donnees = $response->fetch()) {
                ?>
                    <form method='post' action="modification_billets.php?idBillet=<?= $donnees['id']; ?>">
                    <label id="titreBillet" for="titre">Titre:</label><input id="inputTitre" type="text" name="titre" value="<?=$donnees['titre']?>"/><br>
                    <label id="dateBillet" for="post_date">Date:</label><input id="inputDate" type="date" name="post_date" value="<?= $donnees['post_date'] ?>"/><br>
                    <textarea id="zoneTexte" name="contenu" cols="70" rows="20"><?=$donnees['contenu']?></textarea><br>
                    <div id="boutons">
                        <input id="boutonPublier" type="submit" value="Modifier"/>
                        <a href="admin.php?idBillet=<?= $donnees['id']; ?>&supprBillet=1" id="boutonSupprimer">Supprimer</a>
                    </div>
                    </form>
                <?php }
                $response->closeCursor();?>
                
            </div>
        </div>
    
    </body>
</html>