<?php

require_once("./bdd/connexionBdd.php");

function creerCommentaire($pseudo,$nomJeu,$commentaire,$valide){
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
function infoCommentaire(){
    static $ps = null;
    $sql = "SELECT  c.idCommentaire,c.commentaire ,u.pseudo, j.titre  FROM COMMENTAIRE c ,UTILISATEUR u ,JEU j ";
    $sql .= "WHERE c.idUtilisateur =u.idUtilisateur ";
    $sql .= "AND c.idJeu =j.idJeu ";
    $sql .= "AND c.accepte =FALSE ;" ;

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
function validerCommentaire($idCommentaire){
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
function infoJeuCommentaire($titre){
    static $ps = null;
    $sql = "SELECT c.commentaire ,c.dateCommentaire ,u.pseudo ,u.photoDeProfil  FROM COMMENTAIRE c ,UTILISATEUR u,JEU j  ";
    $sql .= "WHERE c.idUtilisateur  = u.idUtilisateur ";
    $sql .= "AND c.idJeu =j.idJeu ";
    $sql .= "AND j.titre =:TITRE ";
    $sql .= "AND c.accepte =TRUE ;" ;

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
    }
    $reponse = false;

    try {
        $ps->bindParam(":TITRE",$titre,PDO::PARAM_STR);
        if ($ps->execute())
            $reponse = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $reponse;
}