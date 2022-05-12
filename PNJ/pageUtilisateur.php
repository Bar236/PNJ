<?php
if (empty($_SESSION)) {
    session_start();
}
require("./fonctionPHP/fonctionUtilisateur.php");
require("./fonctionPHP/fonctionCommentaire.php");
require("./fonctionPHP/fonctionJeux.php");
if (isset($_POST['supCom'])) {
    supprimerCommentaire($_POST['supCom']);
}
if (isset($_POST['supProfile'])) {
    supprimerUtilisateur($_SESSION['nomLog']);
    header('Location: deconnexion.php');
}
if (isset($_POST['passerPublic'])) {
    passerJeuPublic($_POST['passerPublic']);
}
if (isset($_POST['changerProfile'])) {
    $n_pseudo = htmlspecialchars($_POST["pseudo"],  ENT_NOQUOTES);
    $n_mail = htmlspecialchars($_POST["mail"],  ENT_NOQUOTES);
    $n_mdp = htmlspecialchars($_POST["mdp"],  ENT_NOQUOTES);
    if($n_mdp!=""){
        $n_mdp=hash('sha256',$n_mdp);
    }
    
    if(!modifierUtilisateur($_SESSION['nomLog'],$n_pseudo, $n_mail, $n_mdp)){
        echo 'Il y a eu une erreur lors de la modification du compte';
    }
    
}
$data = infoUtilisateur($_SESSION['nomLog']);
$comms = voirCommentaireUtilisateur($_SESSION['nomLog']);
$jeux = listeJeuxUtilisateur($_SESSION['nomLog']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./style/style.css">
    <title>Mon compte</title>
</head>
<!-- Email,Pseudo,PhotoProfil -->

<body>

    <?php include("navbar.php"); ?>
    <div class="container" id="pp">
        <img id="Picture" src="<?= $data[0]['photoDeProfil'] ?>" class="img-thumbnail" alt="...">
        <p> Pseudo : <?= $data[0]["pseudo"] ?></p>
        <p> Email : <?= $data[0]["email"] ?></p>
        <form action="" method="POST">
            <button type="submit" class="btn btn-danger" name="supProfile" value="oui">Supprimer ce profile</button>
        </form>
    </div>
    <div class="container" id="pp">
        <legend>Modifier son profil</legend>
        <form action="#" method="POST">
            <div class="form-group">
                <label for="mail">Nouveau Pseudo</label>
                <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Mon nouveau Pseudo">
                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
            </div>
            <div class="form-group">
                <label for="mail">Nouvelle Adresse Email</label>
                <input type="email" class="form-control" id="mail" name="mail" aria-describedby="emailHelp" placeholder="mon nouveau Mail">
                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
            </div>
            <div class="form-group">
                <label for="mdp">Nouveau Mot de passe</label>
                <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mon nouveau mot de passe">
            </div>
            <div class="form-group">
                <button type="submit" name="changerProfile" class="btn btn-primary">Faire un demande de modification</button><br>
            </div>
        </form>
    </div>
    <div class="container" id="pp">
        <form action="" method="post">
            <legend>tout mes commentaires</legend>
            <ul class="list-group">
                <?php
                for ($i = 0; $i < sizeof($comms); $i++) {
                    echo ' <li class="list-group-item">
               Jeux : ' . $comms[$i]['titre'] . '<br>
               Date : ' . explode(' ', $comms[$i]["dateCommentaire"])[0] . '<br>
               Commentaire : ' . $comms[$i]['commentaire'] . '<br>
               <button type="submit" class="btn btn-primary" name="supCom" value="' . $comms[$i]['idCommentaire'] . '">Supprimer ce commentaire</button>
               </li>
               ';
                }
                ?>
            </ul>
        </form>
    </div>
    <div class="container" id="pp">
        <form action="" method="post">
            <legend>Liste de mes Jeux</legend>
            <ul class="list-group">
                <?php
                for ($i = 0; $i < sizeof($jeux); $i++) {
                    echo ' <li class="list-group-item">
               Titre : ' . $jeux[$i]['titre'] . '<br>
               <img id="testImg" class="card-img-top" src="' . $jeux[$i]['imageJeu'] . '" alt="Aucune image trouvé">
               ';
                    if ($jeux[$i]['public'] == false) {
                        echo '
                <button type="submit" class="btn btn-primary" name="passerPublic" value="' . $jeux[$i]['idJeu'] . '">Passer le jeu en public</button>
                </li>
                ';
                    }
                }
                ?>
        </form>
    </div>
</body>

</html>