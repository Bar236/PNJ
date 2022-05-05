<?php
require_once("./bdd/connexionBdd.php");
function calculerNoteMoyenne($nomJeu)
{
    static $ps = null;
    $sql = "SELECT n.note FROM NOTE n,JEU j ";
    $sql .= "WHERE n.idJeu =j.idJeu ";
    $sql .= "AND j.titre=:TITRE";

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
    }
    $reponse = false;

    try {
        $ps->bindParam(":TITRE", $nomJeu, PDO::PARAM_STR);
        if ($ps->execute())
            $reponse = $ps->fetchAll(PDO::FETCH_ASSOC);
        $moyenne = 0;
        for ($i = 0; $i < sizeof($reponse); $i++) {
            $moyenne += $reponse[$i]['note'];
        }
        $moyenne = $moyenne / sizeof($reponse);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $moyenne;
}
function attribuerMoyenne($moyenne, $nomJeu)
{
    static $ps = null;
    $sql = "UPDATE JEU SET appreciation = :NOTE ";
    $sql .= "WHERE titre = :TITRE";

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
    }
    $reponse = false;

    try {
        $ps->bindParam(":NOTE", $moyenne, PDO::PARAM_STR);
        $ps->bindParam(":TITRE", $nomJeu, PDO::PARAM_STR);
        $reponse = $ps->execute();
    } catch (PDOException $e) {
        echo ($e->getMessage());
    }
    return $reponse;
}
function attribuerNote($note,$nomJeu){
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
