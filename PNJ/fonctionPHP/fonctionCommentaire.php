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