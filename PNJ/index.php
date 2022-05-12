<?php
if (empty($_SESSION)) {
    session_start();
}?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/style.css">
    <link rel="icon" href="image/favicon.ico" type="image/x-icon">
    <title>PNJ</title>

</head>

<body>
    <?php include("navbar.php");
    if (isset($_SESSION['statutLog'])) {
        require_once("./fonctionPHP/fonctionJeux.php");
        echo '<ul class="list-group">';
        echo'<h1>Tout mes jeux</h1>';
        $data = listeJeuxUtilisateur($_SESSION['nomLog']);
        echo '</ul>
        <form action="jeuInfo.php" method="GET">
        ';
        for ($i = 0; $i < sizeof($data); $i++) {
            echo '
            <div class="card">
            <div class="card-header">
            ' . $data[$i]['titre'] . '
            </div>
            <div class="card-body">
            <img id="testImg" class="card-img-top" src="' . $data[$i]['imageJeu'] . '" alt="Aucune image trouvé">
            <p class="card-text"> date de sortie : ' . $data[$i]['dateSorite'] . '<br> catégorie : ' . $data[$i]['categorie'] . '</p>
            <button class="btn btn-primary" name="nomJeu" value="' . $data[$i]['titre'] . '" type="submit">Voir</button>
            </div>
            </div>
            ';
        }
    } else {
    ?>
        <div class="container" id="menu">
            <img src="./image/logoPNJ.png" id="menuLogo" alt="">
            <div class="row align-items-start">

                <div class="col">
                    <a href="login.php" class="btn btn-primary btn-lg">Se connecter</a>
                </div>
                <div class="col">
                    <a href="enregistrer.php" class="btn btn-primary btn-lg">Créer un compte</a>
                </div>
            </div>
        <?php
    }
        ?>
</body>

</html>