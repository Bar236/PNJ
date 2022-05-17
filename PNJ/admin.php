<?php
require_once(".//fonctionPHP/fonctionUtilisateur.php");
require_once(".//fonctionPHP/fonctionCommentaire.php");
if (isset($_POST['bannirUtilisateur'])) {
    bannirUtilisateur($_POST['bannirUtilisateur']);
} else if (isset($_POST['valider'])) {
    validerUtilisateur($_POST['valider']);
} else if (isset($_POST['refuser'])) {
    refuserUtilisateur($_POST['refuser']);
} else if (isset($_POST['validerCom'])) {
    validerCommentaire($_POST['validerCom']);
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
    <title>Administration</title>
</head>

<body>
    <?php
    include("navbar.php");
    $nonInscrit = infoNonVerifier();
    $toutUtilisateur = infoToutUtilisateur();
    $toutCommentaire = infoCommentaire();
    ?>
    <div class="container">
        <div class="row align-items-start">
            <div class="col">
                <h2>les non validés</h2>
                <form action="#" name="testBan" method="post">
                    <ul class="list-group">
                        <?php for ($i = 0; $i < sizeof($nonInscrit); $i++) {
                            echo '
                <li class="list-group-item">
                    <button type="submit" value="' . $nonInscrit[$i]["pseudo"] . '" name="valider">Valider le compte de ' . $nonInscrit[$i]["pseudo"] . '</button>
                    <button type="submit" value="' . $nonInscrit[$i]["pseudo"] . '" name="refuser">Refuser le compte de ' . $nonInscrit[$i]["pseudo"] . '</button>
                </li>';
                        }
                        ?>
                    </ul>
                </form>
            </div>
            <div class="col">
                <h2>tout les utilisateurs</h2>
                <form action="#" name="testValider" method="post">
                    <ul class="list-group">
                        <?php for ($i = 0; $i < sizeof($toutUtilisateur); $i++) {
                            echo '
                <li class="list-group-item">
                    <button type="submit" value="' . $toutUtilisateur[$i]["pseudo"] . '" name="bannirUtilisateur">Bannir le compte de ' . $toutUtilisateur[$i]["pseudo"] . '</button>
                </li>';
                        }
                        ?>
                    </ul>
                </form>
            </div>
            <div class="col">
                <h2>critiques non validés</h2>
                <form action="#" name="testValider" method="post">
                    <ul class="list-group">
                        <?php for ($i = 0; $i < sizeof($toutCommentaire); $i++) {
                            echo '
                <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0" id="scrollComAdmin" class="scrollspy-example" tabindex="0">
                <li class="list-group-item">
                <p>Auteur : '.$toutCommentaire[$i]["pseudo"].'</p>
                <p>Jeux : '.$toutCommentaire[$i]["titre"].'</p>
                <p>Commentaire : '.$toutCommentaire[$i]["commentaire"].'</p>
                    <button type="submit" value="' . $toutCommentaire[$i]["idCommentaire"] . '" name="validerCom">Valider le commentaire de ' . $toutCommentaire[$i]["pseudo"] . ' sur ' . $toutCommentaire[$i]["titre"] . '</button>
                </li> </div>';
                        }
                        ?>
                    </ul>
                </form>
            </div>
        </div>


</body>

</html>