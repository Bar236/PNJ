<?php
require_once("./bdd/connexionBdd.php");

//créer un utilisateur avec le statut inscrit
function creerUtilisateur($pseudo, $mdp, $prenom, $nom, $email, $photo)
{
    static $ps = null;
    $statut = 1;
    $sql = 'INSERT INTO UTILISATEUR (pseudo,motDePasse,prenom,nom,email,idStatut,photoDeProfil)';
    $sql .= 'VALUES (:PSEUDO,:MDP,:PRENOM,:NOM,:MAIL,:STATUT,:PHOTO)';

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
    }
    $reponse = false;

    try {
        $ps->bindParam(":PSEUDO", $pseudo, PDO::PARAM_STR);
        $ps->bindParam(":MDP", $mdp, PDO::PARAM_STR);
        $ps->bindParam(":PRENOM", $prenom, PDO::PARAM_STR);
        $ps->bindParam(":NOM", $nom, PDO::PARAM_STR);
        $ps->bindParam(":MAIL", $email, PDO::PARAM_STR);
        $ps->bindParam(":STATUT", $statut, PDO::PARAM_INT);
        $ps->bindParam(":PHOTO", $photo, PDO::PARAM_STR);

        $reponse = $ps->execute();
    } catch (PDOException $e) {
        echo ($e->getMessage());
    }
    return $reponse;
}

function connecterUtilisateur($email, $mdp)
{
    static $ps = null;
    //sql
    $sql = "SELECT email,motDePasse,pseudo,idStatut FROM UTILISATEUR WHERE email = :EMAIL";

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
        $ps->bindParam(":EMAIL", $email ,PDO::PARAM_STR);
    }
    $reponse = false;

    try {
        if ($ps->execute())
            $reponse = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    if (count($reponse) > 0) {
        if ($email == $reponse[0]["email"] && $mdp == $reponse[0]["motDePasse"]) {
            if ($reponse[0]["idStatut"] == 2 || $reponse[0]["idStatut"] == 6) {
                if (empty($_SESSION)) {
                    session_start();
                }
                $_SESSION['nomLog'] = $reponse[0]["pseudo"];
                $_SESSION['statutLog'] = $reponse[0]["idStatut"];
                $reponse= true;
            }
            //le compte existe mais soit il est pas vérifier , banni, refusé ,supprimé
        }
    }
    return $reponse;
}
// changer le statut d'un utilisateur d'inscrit à accepté
function validerUtilisateur($pseudo)
{
    static $ps = null;
    $sql = "UPDATE UTILISATEUR SET idStatut = 2 ";
    $sql .= "WHERE pseudo = :PSEUDO";

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
    }
    $reponse = false;

    try {
         $ps->bindParam(":PSEUDO", $pseudo, PDO::PARAM_STR);

        $reponse = $ps->execute();
    } catch (PDOException $e) {
        echo ($e->getMessage());
    }
    return $reponse;
}
// changer le statut d'un utilisateur accepté à refusé
function refuseUtilisateur($pseudo)
{
    static $ps = null;
    $sql = "UPDATE UTILISATEUR SET idStatut = 3 ";
    $sql .= "WHERE pseudo = :PSEUDO";

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
    }
    $reponse = false;

    try {
         $ps->bindParam(":PSEUDO", $pseudo, PDO::PARAM_STR);

        $reponse = $ps->execute();
    } catch (PDOException $e) {
        echo ($e->getMessage());
    }
    return $reponse;
}
// changer le statut d'un utilisateur accepté à banni
function bannirUtilisateur($pseudo)
{
    static $ps = null;
    $sql = "UPDATE UTILISATEUR SET idStatut = 4 ";
    $sql .= "WHERE pseudo = :PSEUDO";

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
    }
    $reponse = false;

    try {
         $ps->bindParam(":PSEUDO", $pseudo, PDO::PARAM_STR);

        $reponse = $ps->execute();
    } catch (PDOException $e) {
        echo ($e->getMessage());
    }
    return $reponse;
}
// changer le statut d'un utilisateur accepté à supprimé
function supprimerUtilisateur($pseudo)
{
    static $ps = null;
    $sql = "UPDATE UTILISATEUR SET idStatut = 5 ";
    $sql .= "WHERE pseudo = :PSEUDO";

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
    }
    $reponse = false;

    try {
         $ps->bindParam(":PSEUDO", $pseudo, PDO::PARAM_STR);

        $reponse = $ps->execute();
    } catch (PDOException $e) {
        echo ($e->getMessage());
    }
    return $reponse;
}
//retourne tout les utilisateurs non vérifier
function infoNonVerifier()
{
    static $ps = null;
    $sql = "SELECT pseudo,idUtilisateur from UTILISATEUR";
    $sql .= " WHERE idStatut =1";

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
    }
    $reponse = false;

    try {
        if ($ps->execute())
            $reponse = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $reponse;
}
//retourne tout les utilisateurs
function infoToutUtilisateur()
{
    static $ps = null;
    $sql = "SELECT pseudo,idUtilisateur from UTILISATEUR";

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
    }
    $reponse = false;

    try {
        if ($ps->execute())
            $reponse = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $reponse;
}
//retourne un utilisateur
function infoUtilisateur($pseudo)
{
    static $ps = null;
    $sql = "SELECT * from UTILISATEUR WHERE pseudo = :PSEUDO";

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
    }
    $reponse = false;

    try {
        $ps->bindParam(":PSEUDO",$pseudo,PDO::PARAM_STR);
        if ($ps->execute())
            $reponse = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $reponse;
}
