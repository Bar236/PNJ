<?php
if (empty($_SESSION)) {
    session_start();
}
if (isset($_GET['nomJeu'])) {
    require_once('./fonctionPHP/fonctionJeux.php');
    require_once('./fonctionPHP/fonctionNote.php');
    require_once("./fonctionPHP/fonctionCommentaire.php");
    $nomJeu = htmlspecialchars($_GET['nomJeu'], ENT_NOQUOTES);

    if (isset($_POST['commentaire'])) {
        $critique = htmlspecialchars($_POST['critique'], ENT_NOQUOTES);
        creerCommentaire($_SESSION['nomLog'], $nomJeu, $critique, false);
    }
    if (isset($_POST['note'])) {
        if (ajouterNote($_POST['note'], $_SESSION['nomLog'], $nomJeu) != false) {
            $moyenne = calculerNoteMoyenne($nomJeu);
            attribuerMoyenne($moyenne, $nomJeu);
        }
    }
    $data = infoJeu($nomJeu);
} else {
    header("Location: index.php");
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
    <title>Document</title>
</head>

<body>
    <?php include("navbar.php");
    ?>
    <div class="container py-4">
        <!-- <header class="pb-3 mb-4 border-bottom">
       <a href="index.php" class="d-flex align-items-center text-dark text-decoration-none">
        <span class="fs-4">Retour au Menu</span>
      </a> -->
        </header>
        <div class="p-5 mb-4 bg-light rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold"><?php echo ($nom) ?></h1>
                <p class="col-md-8 fs-4">
                    <?= "développé par : " . $data[0]['editeur'] ?>
                </p>
                <p class="col-md-8 fs-4">
                    <?= "Sortie le : " . $data[0]['dateSorite'] ?>
                </p>
                <p class="col-md-8 fs-4">
                    <?= "Note des utilisateur  : " . $data[0]['appreciation'] . '/10' ?>
                </p>
                <div class="row align-items-md-stretch">
                    <?php echo '
        <img class="imageJeu" src="' . ($data[0]['imageJeu']) . '"alt="...">
        ' ?>
                    <span class="desc"><?= $data[0]['description'] ?></span>
                    <!-- <div class="box">
            <img src="https://www.smashbros.com/assets_v2/img/fighter/steve/main.png">
            <span style=""></span>
          </div> -->
                </div>
            </div>
        </div>
        <div class="row align-items-md-stretch">
            <div class="col-md-6">
                <div class="h-100 p-5 text-white bg-dark rounded-3">
                    <h2>Genres</h2>
                    <ul class="listeP">
                        <li><?= $data[0]['categorie'] ?></li>
                    </ul>
                    <!--<button class="btn btn-outline-secondary" type="button">Example button</button>-->
                </div>
            </div>
            <div class="col-md-6">
                <form action="" method="POST">
                    <input type="number" name="note" id="note" min="0" max="10" value="5">
                    <button type="submit" name="noteJeu">Noter le jeu</button>
                </form>
            </div>
            <form action="#" method="POST">
                <div class="card">
                    <div class="card-body">
                        <div class="form-floating">
                            <p>Rédiger votre critique</p>
                            <textarea class="form-control" name="critique" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                        </div>
                        <button type="submit" name="commentaire" class="btn btn-primary">Envoyer le commentaire</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row align-items-md-stretch">
            <?php
            $commentaires = infoJeuCommentaire($nomJeu);
            for ($i = 0; $i < sizeof($commentaires); $i++) {

                echo '<li class="list-group-item" id="topique">
                <div class="card-body">
                    <h5>' . $commentaires[$i]["pseudo"] . '</h5>
                    <h5>' .  explode(' ', $commentaires[$i]["dateCommentaire"])[0] . '</h5>
                    <img src="' . $commentaires[$i]["photoDeProfil"] . '" alt="" class="imgP">
                    <p>' . $commentaires[$i]["commentaire"] . '</p>
                </div>
            </li>';
            }
            ?>
        </div>
</body>

</html>