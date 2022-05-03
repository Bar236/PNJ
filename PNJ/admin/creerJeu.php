<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../style/style.css">
    <title>Ajouter un jeu</title>
</head>
<body>
    <?php
    include("../navbar.php");
    ?>
    <form action="#" method="post" id="login">
        <div class="form-group">
            <label for="titre">Titre</label>
            <input type="text" class="form-control" id="titre" name="titre" placeholder="Stardew Valley">
        </div>

        <div class="form-group">
            <label for="editeur">Editeur</label>
            <input type="text" class="form-control" id="editeur" name="editeur" placeholder="ConcernedApe">
        </div>
        <div class="form-group">
            <label for="dateSortie">dateSortie</label>
            <input type="date" class="form-control" id="dateSortie" name="dateSortie">
        </div>

        <div class="form-floating">
            <textarea class="form-control" id="floatingTextarea"></textarea>
            <label for="floatingTextarea">Résumé du jeu</label>
        </div>
        <select class="form-select" aria-label="Default select example">
            <option selected>Bac à sable</option>
            // récupérer les catégories sur la base
        </select>
        <div class="form-group">
            <label for="photo">Image du jeu</label>
            <input type="file" class="form-control" name="photo" accept="image/*/" id="photo">
        </div>

        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
        <label class="form-check-label" for="flexCheckDefault">
            Rendre le jeu privé ?
        </label>

        <div class="form-group">
            <button type="submit" name="CreerJeu" class="btn btn-primary">Se connecter</button><br>
            <a href="enregistrer.php">Je n'ai pas de compte</a>
        </div>

    </form>
</body>

</html>