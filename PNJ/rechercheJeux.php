<?php
require_once("./fonctionPHP/fonctionJeux.php");

if (isset($_GET['recherche'])) {
    $titre = htmlspecialchars($_GET['titreJeu'], ENT_NOQUOTES);
    $categorie = htmlspecialchars($_GET['categorie'], ENT_NOQUOTES);
    $annee = htmlspecialchars($_GET['anneeJeu'], ENT_NOQUOTES);
    $moyenne = htmlspecialchars($_GET['noteJeu'], ENT_NOQUOTES);
    $auteur = htmlspecialchars($_GET['auteur'], ENT_NOQUOTES);

    $data = rechercheJeu($titre, $categorie, $annee, $moyenne,$auteur);
    $legend="Résultat de la recherche";
} else {
    $data = recupererJeux();
    $legend="Derniers jeux ajoutés";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/style.css">
    <script src="./js/script.js"></script>
    <title>Recherche</title>
</head>

<body>
    <?php include("navbar.php") ?>
    <div class="container">
        <div class="row align-items-start">
            <div class="col">
                <legend><?=$legend?></legend>
                <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0" id="scrollTest" class="scrollspy-example" tabindex="0">

                    <?php

                    for ($i = 0; $i < sizeof($data); $i++) {
                        echo '
                        <div class="card" id="carteRecherche" style="width: 30rem;">
                    <img src="' . $data[$i]['imageJeu'] . '" id="imgrecherche" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">' . $data[$i]['titre'] . '</p>
                        <p class="card-text"> Note des utilisateurs : ' . $data[$i]['appreciation'] . '/10</p>
                        <form action="jeuInfo.php" method="GET">
                        <button class="btn btn-primary" name="nomJeu" value="' . $data[$i]['titre'] . '" type="submit">Voir</button>
                        </form>
                    </div>
                </div>
                        ';
                    }

                    ?>
                </div>
                <!-- <div class="card" style="width: 18rem;">
                    <img src="https://pbs.twimg.com/profile_images/1452956876346384394/sSAwNeLO_400x400.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <form action="jeuInfo.php" method="GET">
                        <button class="btn btn-primary" name="nomJeu" value="Minecraft" type="submit">Voir</button>
                        </form>
                    </div>
                </div> -->
            </div>
            <div class="col">
                <fieldset>
                    <legend>Options de recherche</legend>

                    <form action="" method="GET" id="recherche">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="titreJeu" class="col-form-label">Titre du Jeu :</label>
                            </div>
                            <div class="col-auto">
                                <input type="text" id="titreJeu" name="titreJeu" class="form-control">
                            </div>
                        </div>
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="auteur" class="col-form-label">Auteur :</label>
                            </div>
                            <div class="col-auto">
                                <input type="text" id="auteur" name="auteur" class="form-control">
                            </div>
                        </div>

                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="categorie" class="col-form-label">Catégorie :</label>
                            </div>
                            <div class="col-auto">
                                <select class="form-select" name="categorie" aria-label="Default select example">
                                    <option value="" selected>Tout</option>
                                    <?php
                                    $data = infoCategorie();
                                    for ($i = 0; $i < sizeof($data); $i++) {
                                        echo '<option value="' . $data[$i]["idCategorie"] . '">' . $data[$i]["categorie"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="anneeJeu" class="col-form-label">Année de sortie :</label>
                            </div>
                            <div class="col-auto">
                                <input type="number" name="anneeJeu" id="anneeJeu" class="form-control">
                            </div>
                        </div>
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="noteJeu" class="col-form-label">Note minimal :</label>
                            </div>
                            <div class="col-auto">
                                <input type="number" id="noteJeu" name="noteJeu" class="form-control">
                            </div>
                        </div>
                        <button type="submit" name="recherche" class="btn btn-primary">Rechercher</button>
                    </form>
                    <button class="btn btn-primary" onclick="effacerForm()">Effacer</button>
                </fieldset>
            </div>
        </div>
    </div>
</body>

</html>