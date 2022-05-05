<?php
require_once(".//fonctionPHP/fonctionUtilisateur.php");
if (isset($_POST['ban'])) {
    bannirUtilisateur("SaltyMaster");
} else if (isset($_POST['valider'])) {
    validerUtilisateur($_POST['valider']);
} else if (isset($_POST['refuser'])) {
    refuseUtilisateur($_POST['refuser']);
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
    ?>
    <form action="#" name="testBan" method="post">
        <ul class="list-group">
            <?php for ($i = 0; $i < sizeof($nonInscrit); $i++) {
            echo'
                <li class="list-group-item">
                    <button type="submit" value="'.$nonInscrit[$i]["pseudo"].'" name="valider">Valider le compte de '.$nonInscrit[$i]["pseudo"].'</button>
                    <button type="submit" value="'.$nonInscrit[$i]["pseudo"].'" name="refuser">Refuser le compte de '.$nonInscrit[$i]["pseudo"].'</button>
                </li>';
            
            }
            ?>
        </ul>
    </form>
    <form action="#" name="testValider" method="post">
        <!-- <button type="submit" name="ban" value="c'est un test">Bannir SaltyMaster</button>-->
    </form>
</body>

</html>