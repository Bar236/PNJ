<?php
require_once("./bdd/connexionBdd.php");

/**
 * permet de creer un utilisateur dans la base de données
 *
 * @param [string] $pseudo
 * @param [string] $mdp
 * @param [string] $prenom
 * @param [string] $nom
 * @param [string] $email
 * @param [string] $photo
 * @return bool
 */
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
/**
 * modifie le profile d'un utilisateur
 *
 * @param [string] $pseudo
 * @param [string] $n_pseudo
 * @param [string] $n_mail
 * @param [string] $n_mdp
 * @return bool
 */
function modifierUtilisateur($pseudo,$n_pseudo, $n_mail, $n_mdp)
{
    static $ps = null;
    $sql = "UPDATE UTILISATEUR SET ";
    if ($n_pseudo != "") {
        $sql .= "pseudo = :NPSEUDO ";
        if ($n_mail != "") {
            $sql .= ", email = :EMAIL ";
        }
        if ($n_mdp != "") {
            $sql .= ", motDePasse = :MDP ";
        }
    } elseif ($n_mail != "") {
        $sql .= "email = :EMAIL ";
        if ($n_mdp != "") {
            $sql .= ", motDePasse = :MDP ";
        }
    } elseif ($n_mdp != "") {
        $sql .= "motDePasse = :MDP ";
    }
    $sql .= "WHERE pseudo = :PSEUDO";

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
    }
    $reponse = false;

    try {
        $ps->bindParam(":PSEUDO", $pseudo, PDO::PARAM_STR);
        if ($n_pseudo != "") {$ps->bindParam(":NPSEUDO", $n_pseudo, PDO::PARAM_STR);}
        if ($n_mail != "") {$ps->bindParam(":EMAIL", $n_mail, PDO::PARAM_STR);}
        if ($n_mdp != "") {$ps->bindParam(":MDP", $n_mdp, PDO::PARAM_STR);}
        //$ps->bindParam(":PSEUDO", $pseudo, PDO::PARAM_STR);

        $reponse = $ps->execute();
        if($reponse==true){
            if (empty($_SESSION)) {
                session_start();
            }
            $_SESSION['nomLog']=$n_pseudo;
        }
    } catch (PDOException $e) {
        echo ($e->getMessage());
    }
    return $reponse;
}
/**
 * vérifie si le mot de passe et l'email de l'utilisateur sont correctes
 *
 * @param [string] $email
 * @param [string] $mdp
 * @return bool
 */
function connecterUtilisateur($email, $mdp)
{
    static $ps = null;
    //sql
    $sql = "SELECT email,motDePasse,pseudo,idStatut FROM UTILISATEUR WHERE email = :EMAIL";

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
        $ps->bindParam(":EMAIL", $email, PDO::PARAM_STR);
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
                $reponse = true;
            } else {
                $reponse = false;
            }
            //le compte existe mais soit il est pas vérifier , banni, refusé ,supprimé
        }else{
            $reponse = false;
        }
    }
    return $reponse;
}
/**
 * modifie le statut d'utilisateur à valider
 *
 * @param [string] $pseudo
 * @return void
 */
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
/**
 * modifie le statut d'utilisateur à refuse
 *
 * @param [string] $pseudo
 * @return void
 */
function refuserUtilisateur($pseudo)
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
/**
 * modifie le statut d'utilisateur à banni
 *
 * @param [string] $pseudo
 * @return void
 */
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
/**
 * modifie le statut d'utilisateur à supprimer
 *
 * @param [string] $pseudo
 * @return void
 */
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
/**
 * retourne un tableau de tout les utilisateur qui ne sont pas vérifier
 *
 * @return array
 */
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
/**
 * retourne un tableau de tout les utilisateur qui ne sont pas admins
 *
 * @return array
 */
function infoToutUtilisateur()
{
    static $ps = null;
    $sql = "SELECT pseudo,idUtilisateur from UTILISATEUR WHERE idStatut = 2";

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
/**
 * retourne toute les information sur un utilisateur
 *
 * @param [string] $pseudo
 * @return array
 */
function infoUtilisateur($pseudo)
{
    static $ps = null;
    $sql = "SELECT * from UTILISATEUR WHERE pseudo = :PSEUDO";

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
    }
    $reponse = false;

    try {
        $ps->bindParam(":PSEUDO", $pseudo, PDO::PARAM_STR);
        if ($ps->execute())
            $reponse = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $reponse;
}
