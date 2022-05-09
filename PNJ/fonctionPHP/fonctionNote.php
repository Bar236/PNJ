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

function ajouterNote($note,$pseudo,$titre){
    static $ps = null;
    $sql = "INSERT INTO NOTE (note,idUtilisateur,idJeu) ";
    $sql .= "SELECT :NOTE ,u.idUtilisateur ,j.idJeu ";
    $sql .="FROM JEU j, UTILISATEUR u ";
    $sql .="WHERE u.pseudo =:PSEUDO ";
    $sql .="AND j.titre =:TITRE ";

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
    }
    $reponse = false;

    try {
        $ps->bindParam(":NOTE", $note, PDO::PARAM_INT);
        $ps->bindParam(":TITRE", $titre, PDO::PARAM_STR);
        $ps->bindParam(":PSEUDO",$pseudo,PDO::PARAM_STR);
        $reponse = $ps->execute();
    } catch (PDOException $e) {
        echo ($e->getMessage());
    }
    return $reponse;
}
