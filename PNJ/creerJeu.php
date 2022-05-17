<?php
if (empty($_SESSION)) {
    session_start();
}
require_once("./fonctionPHP/fonctionJeux.php");
if (isset($_POST['CreerJeu'])) {
    $titre = htmlspecialchars($_POST['titre'], ENT_NOQUOTES);
    $editeur = htmlspecialchars($_POST["editeur"], ENT_NOQUOTES);
    $dateSortie = htmlspecialchars($_POST["dateSortie"],  ENT_NOQUOTES);
    $description = htmlspecialchars($_POST["description"],  ENT_NOQUOTES);
    $categorie = htmlspecialchars($_POST["categorie"],  ENT_NOQUOTES);
    $public = true;
    if ($_POST['public'] == "on") {
        $public = false;
    }
    $data = file_get_contents($_FILES['photo']['tmp_name']);
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($_FILES['photo']['tmp_name']);
    $src = 'data:' . $mime . ';base64,' . base64_encode($data);
    creerJeu($titre, $dateSortie, $editeur, $description, $public, $categorie, $src, $_SESSION['nomLog']);
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
    <title>Ajouter un jeu</title>
</head>

<body>
    <?php
    include("navbar.php");
    ?>
    <form action="#" method="post" id="login" enctype="multipart/form-data">
        <div class="form-group">
            <label for="titre">Titre</label>
            <input type="text" class="form-control" id="titre" name="titre" placeholder="Stardew Valley" required>
        </div>

        <div class="form-group">
            <label for="editeur">Editeur</label>
            <input type="text" class="form-control" id="editeur" name="editeur" placeholder="ConcernedApe" required>
        </div>
        <div class="form-group">
            <label for="dateSortie">Date de sortie</label>
            <input type="date" class="form-control" id="dateSortie" name="dateSortie" required>
        </div>

        <div class="form-floating">
            <textarea class="form-control" name="description" id="floatingTextarea" required></textarea>
            <label for="floatingTextarea">Résumé du jeu</label>
        </div>
        <select class="form-select" name="categorie" aria-label="Default select example" required>
            <?php
            $data = infoCategorie();
            for ($i = 0; $i < sizeof($data); $i++) {
                echo '<option value="' . $data[$i]["idCategorie"] . '" selected>' . $data[$i]["categorie"] . '</option>';
            }
            ?>
            <!-- // récupérer les catégories sur la base -->
        </select>
        <div class="form-group">
            <label for="photo">Image du jeu</label>
            <input type="file" class="form-control" name="photo" accept="image/*/" id="photo">
        </div>

        <input class="form-check-input" name="public" type="checkbox" id="flexCheckDefault">
        <label class="form-check-label" for="flexCheckDefault">
            Rendre le jeu privé ?
        </label>

        <div class="form-group">
            <button type="submit" name="CreerJeu" class="btn btn-primary">Créer le jeu</button>
            <button class="btn btn-primary" onclick="effacerForm()">Effacer</button>
        </div>

    </form>
</body>

</html>