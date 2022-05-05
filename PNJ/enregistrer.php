<?php
if (isset($_POST['Creer'])) {
    $prenom = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_STRING);
    $nom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_STRING);
    $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_STRING);
    $mail = filter_input(INPUT_POST, "mail", FILTER_SANITIZE_EMAIL);
    $mdp = filter_input(INPUT_POST, "mdp", FILTER_SANITIZE_STRING);
    $m2p = filter_input(INPUT_POST, "m2p", FILTER_SANITIZE_STRING);

    if ($mdp == $m2p) {
        $mdp = hash('sha256', $mdp);
        //image
        $data = file_get_contents($_FILES['img']['tmp_name']);
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($_FILES['img']['tmp_name']);
        $src = 'data:' . $mime . ';base64,' . base64_encode($data);

        require("./fonctionPHP/fonctionUtilisateur.php");
        creerUtilisateur($pseudo,$mdp,$prenom,$nom,$mail,$src);
    }
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
    <title>Créer un compte</title>
</head>

<body>
    <?php include("navbar.php") ?>
    <form action="#" method="post" class="creer" id="login" enctype="multipart/form-data">
        <div class="form-group">
            <label for="prenom">Prenom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Mike" required>
        </div>
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" placeholder="Oxlong" required>
        </div>
        <div class="form-group">
            <label for="pseudo">Pseudo</label>
            <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="sylvain_Dudrift" required>
        </div>
        <div class="form-group">
            <label for="mail">Adresse Email</label>
            <input type="email" class="form-control" id="mail" name="mail" aria-describedby="emailHelp" placeholder="Mike.oxlong@chungus.com" required>
        </div>
        <div class="form-group">
            <label for="mdp">Mot de passe</label>
            <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe" required>
        </div>
        <div class="form-group">
            <label for="m2p">Répéter le mot de passe</label>
            <input type="password" class="form-control" id="m2p" name="m2p" required>
        </div>
        <div class="form-group">
            <label for="img">Photo de profile</label>
            <input type="file" class="form-control" name="img" accept="image/png, image/gif, image/jpeg" id="img">
        </div>
        <button type="submit" name="Creer" class="btn btn-primary">Créer mon compte</button>
        <a href="login.php">J'ai déjà un compte</a>
    </form>
</body>

</html>