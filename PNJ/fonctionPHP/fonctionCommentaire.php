<?php

require_once("./bdd/connexionBdd.php");
/**
 * ajoute un commentaire dans la base de données
 *
 * @param [string] $pseudo
 * @param [string] $nomJeu
 * @param [string] $commentaire
 * @param [bool] $valide
 * @return void
 */
function creerCommentaire($pseudo, $nomJeu, $commentaire, $valide)
{
    static $ps = null;
    $statut = 1;
    $sql = 'INSERT INTO COMMENTAIRE (idUtilisateur,idJeu,accepte,dateCommentaire,commentaire) ';
    $sql .= 'SELECT UTILISATEUR.idUtilisateur,JEU.idJeu ,:ACCEPTE,:DATECOMMENTAIRE,:COMMENTAIRE FROM UTILISATEUR,JEU ';
    $sql .= 'WHERE JEU.titre= :TITRE ';
    $sql .= 'AND UTILISATEUR.pseudo= :PSEUDO ';

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
    }
    $reponse = false;

    try {
        $ps->bindParam(":PSEUDO", $pseudo, PDO::PARAM_STR);
        $ps->bindParam(":TITRE", $nomJeu, PDO::PARAM_STR);
        $ps->bindParam(":ACCEPTE", $valide, PDO::PARAM_BOOL);
        $ps->bindParam(":COMMENTAIRE", $commentaire, PDO::PARAM_STR);
        $ps->bindParam(":DATECOMMENTAIRE", date('Y-m-d'), PDO::PARAM_STR);

        $reponse = $ps->execute();
    } catch (PDOException $e) {
        echo ($e->getMessage());
    }
    return $reponse;
}
/**
 * modifie le contenue d'un commentaire
 *
 * @param [string] $n_comm
 * @param [string] $idCom
 * @return void
 */
function moddifierCommentaire($n_comm,$idCom){
    static $ps = null;
    $sql = "UPDATE COMMENTAIRE SET commentaire = :COMM ";
    $sql .= "WHERE idCommentaire = :IDCOM";

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
    }
    $reponse = false;

    try {
        $ps->bindParam(":COMM",$n_comm,PDO::PARAM_STR);
        $ps->bindParam(":IDCOM", $idCom, PDO::PARAM_INT);

        $reponse = $ps->execute();
    } catch (PDOException $e) {
        echo ($e->getMessage());
    }
    return $reponse;
}
/**
 * retourne un tableau de tout les commentaire non-validés
 *
 * @return array
 */
function infoCommentaire()
{
    static $ps = null;
    $sql = "SELECT  c.idCommentaire,c.commentaire ,u.pseudo, j.titre  FROM COMMENTAIRE c ,UTILISATEUR u ,JEU j ";
    $sql .= "WHERE c.idUtilisateur =u.idUtilisateur ";
    $sql .= "AND c.idJeu =j.idJeu ";
    $sql .= "AND c.accepte =FALSE ;";

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
 * change le status d'un commentaire de non-validé à validé
 *
 * @param [int] $idCommentaire
 * @return void
 */
function validerCommentaire($idCommentaire)
{
    static $ps = null;
    $sql = "UPDATE COMMENTAIRE SET accepte = true ";
    $sql .= "WHERE idCommentaire = :IDCOM";

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
    }
    $reponse = false;

    try {
        $ps->bindParam(":IDCOM", $idCommentaire, PDO::PARAM_INT);

        $reponse = $ps->execute();
    } catch (PDOException $e) {
        echo ($e->getMessage());
    }
    return $reponse;
}
/**
 * retorune tout les commentaires d'un jeu
 *
 * @param [string] $titre
 * @return array
 */
function infoJeuCommentaire($titre)
{
    static $ps = null;
    $sql = "SELECT c.idCommentaire,c.commentaire ,c.dateCommentaire ,u.pseudo ,u.photoDeProfil  FROM COMMENTAIRE c ,UTILISATEUR u,JEU j  ";
    $sql .= "WHERE c.idUtilisateur  = u.idUtilisateur ";
    $sql .= "AND c.idJeu =j.idJeu ";
    $sql .= "AND j.titre =:TITRE ";
    $sql .= "AND c.accepte =TRUE ;";

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
    }
    $reponse = false;

    try {
        $ps->bindParam(":TITRE", $titre, PDO::PARAM_STR);
        if ($ps->execute())
            $reponse = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $reponse;
}
/**
 * retourne tout les commentaires d'un utilisateur
 *
 * @param [string] $pseudo
 * @return array
 */
function voirCommentaireUtilisateur($pseudo)
{
    static $ps = null;
    $sql = "SELECT j.titre, c.idCommentaire ,c.dateCommentaire ,c.commentaire  FROM COMMENTAIRE c ,JEU j,UTILISATEUR u ";
    $sql .= "WHERE j.idJeu =c.idJeu ";
    $sql .= "AND u.idUtilisateur =c.idUtilisateur ";
    $sql .= "AND u.pseudo = :PSEUDO ";
    $sql .= "AND c.accepte =true ";

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
/**
 * passe le statut d'un commentaire de validé à non-validé
 *
 * @param [int] $idCommentaire
 * @return void
 */
function supprimerCommentaire($idCommentaire)
{
    static $ps = null;
    $sql = "UPDATE COMMENTAIRE SET accepte = false ";
    $sql .= "WHERE idCommentaire = :IDCOM";

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
    }
    $reponse = false;

    try {
        $ps->bindParam(":IDCOM", $idCommentaire, PDO::PARAM_INT);

        $reponse = $ps->execute();
    } catch (PDOException $e) {
        echo ($e->getMessage());
    }
    return $reponse;
}
