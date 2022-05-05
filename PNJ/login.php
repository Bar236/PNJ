<?php
if(isset($_POST['log'])){
  $mail = filter_input(INPUT_POST, "mail", FILTER_VALIDATE_EMAIL);
  $mdp = htmlspecialchars($_POST['mdp'], ENT_NOQUOTES);
  require("./fonctionPHP/fonctionUtilisateur.php");
  $mdp=hash('sha256',$mdp);
  if(connecterUtilisateur($mail,$mdp)==true){
    header("Location: index.php");
  }else{
    echo"Le compte n'existe pas ou n'est pas activé";
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
    <title>Se connecter</title>
</head>
<body>
<?php include("navbar.php") ?>
<form action="#" method="post" id="login">
    <div class="form-group">
      <label for="mail">Adresse Email</label>
      <input type="email" class="form-control" id="mail" name="mail" aria-describedby="emailHelp" placeholder="Mon adresse Email">
      <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
    </div>
    <div class="form-group">
      <label for="mdp">Mot de passe</label>
      <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mon mot de passe">
    </div>
    <div class="form-group">
      <button type="submit" name="log" class="btn btn-primary">Se connecter</button><br>
      <a href="enregistrer.php">Je n'ai pas de compte</a>
    </div>
  </form>
</body>
</html>