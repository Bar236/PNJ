<?php
if (empty($_SESSION)) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-light" id="navbarMain">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="./image/logoPNJ.png" id="navLogo" alt="PNJ">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Acceuil</a>
                </li>
                <?php
                if (isset($_SESSION["nomLog"])) {
                    echo '<li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="rechercheJeux.php">Jeux</a>
                    </li>';
                    echo '<li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="creerJeu.php">Ajouter un jeu</a>
                         </li>';
                }
                if ($_SESSION["statutLog"] == "6") {
                    echo '
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="admin.php">Gérer les utilisateurs</a>
                    </li>
                    ';
                }
                ?>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php //Mon compte
                        //$_SESSION["nomLog"]="Bar";
                        if (isset($_SESSION["nomLog"])) {
                            echo $_SESSION["nomLog"];
                        } else {
                            echo 'Login';
                        }
                        ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php
                        if (isset($_SESSION["nomLog"])) {
                            //     echo '<li class="nav-item">
                            //     <a class="nav-link active" aria-current="page" href="creerJeu.php">Ajouter un jeu</a>
                            // </li>';
                            echo '<li><a class="dropdown-item" href="pageUtilisateur.php">Mon compte</a></li>';
                            echo '<li>
                        <hr class="dropdown-divider">
                        </li>';
                            echo '<li><a class="dropdown-item" href="deconnexion.php">Déconnexion</a></li>';
                        } else {
                            echo '<li><a class="dropdown-item" href="login.php">Se connecter</a></li>';
                            echo '<li><a class="dropdown-item" href="enregistrer.php">Créer un compte</a></li>';
                        }
                        ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>