<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/style.css">
    <title>PNJ</title>

</head>

<body>
    <?php include("navbar.php");
    if (isset($_SESSION['statutLog'])) {
        require_once("./fonctionPHP/fonctionJeux.php");
        echo '<ul class="list-group">';
        $data = recupererJeux();
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
    }
    ?>
</body>

</html>