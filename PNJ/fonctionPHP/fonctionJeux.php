<?php
require_once("./bdd/connexionBdd.php");
function creerJeu($titre, $date, $editeur, $description, $public, $idCategorie, $photo)
{
    static $ps = null;
    $statut = 1;
    $sql = 'INSERT INTO JEU (titre,dateSorite,editeur,description,public,idCategorie,imageJeu)';
    $sql .= 'VALUES (:TITRE,:DATE,:EDITEUR,:DESCRIPTION,:PUBLIC,:IDCATEGORIE,:IMAGE)';

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
    }
    $reponse = false;

    try {
        $ps->bindParam(":TITRE", $titre, PDO::PARAM_STR);
        $ps->bindParam(":DATE", $date, PDO::PARAM_STR);
        $ps->bindParam(":EDITEUR", $editeur, PDO::PARAM_STR);
        $ps->bindParam(":DESCRIPTION", $description, PDO::PARAM_STR);
        $ps->bindParam(":PUBLIC", $public, PDO::PARAM_BOOL);
        $ps->bindParam(":IDCATEGORIE", $idCategorie, PDO::PARAM_INT);
        $ps->bindParam(":IMAGE", $photo, PDO::PARAM_STR);

        $reponse = $ps->execute();
    } catch (PDOException $e) {
        echo ($e->getMessage());
        $reponse = $e->getMessage();
    }
    return $reponse;
}
function recupererJeux()
{
    static $ps = null;
    $sql = "SELECT j.titre,j.imageJeu,j.dateSorite ,c.categorie  FROM JEU j , CATEGORIE c ";
    $sql .= "WHERE j.idCategorie =c.idCategorie ;";

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
function infoCategorie()
{
    static $ps = null;
    $sql = "SELECT * from CATEGORIE";

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
function infoJeu($nomJeu)
{
    static $ps = null;
    $sql = "SELECT j.titre ,j.imageJeu ,j.editeur ,j.dateSorite ,j.appreciation,j.description  ,c.categorie ";
    $sql .= "FROM JEU j , CATEGORIE c ";
    $sql .= "WHERE c.idCategorie =j.idCategorie  ";
    $sql .= "AND j.titre = :TITRE ";

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
    }
    $reponse = false;

    try {
        $ps->bindParam(":TITRE", $nomJeu, PDO::PARAM_STR);
        if ($ps->execute())
            $reponse = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $reponse;
}

