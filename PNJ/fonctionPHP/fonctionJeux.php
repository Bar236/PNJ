<?php
require_once("./bdd/connexionBdd.php");
/**
 * ajoute un jeu dans la base de données
 *
 * @param [string] $titre
 * @param [string] $date
 * @param [string] $editeur
 * @param [string] $description
 * @param [bool] $public
 * @param [int] $idCategorie
 * @param [string] $photo
 * @param [string] $pseudo
 * @return void
 */
function creerJeu($titre, $date, $editeur, $description, $public, $idCategorie, $photo,$pseudo)
{
    static $ps = null;
    $sql = 'INSERT INTO JEU (titre,dateSorite,editeur,description,public,idCategorie,imageJeu,idUtilisateur) ';
    $sql .= 'SELECT :TITRE, :DATE, :EDITEUR, :DESCRIPTION, :PUBLIC, :IDCATEGORIE, :IMAGEJEU, UTILISATEUR.idUtilisateur FROM UTILISATEUR  ';
    $sql .='WHERE UTILISATEUR.pseudo = :PSEUDO ';

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
        $ps->bindParam(":IMAGEJEU", $photo, PDO::PARAM_STR);
        $ps->bindParam(":PSEUDO", $pseudo, PDO::PARAM_STR);

        $reponse = $ps->execute();
    } catch (PDOException $e) {
        echo ($e->getMessage());
        $reponse = $e->getMessage();
    }
    return $reponse;
}
/**
 * récupère tout les jeux public de la base de données
 *
 * @return array
 */
function recupererJeux()
{
    static $ps = null;
    $sql = "SELECT j.titre,j.imageJeu,j.dateSorite,j.appreciation,c.categorie  FROM JEU j , CATEGORIE c ";
    $sql .= "WHERE j.idCategorie =c.idCategorie AND j.public = true ";
    $sql .= "ORDER BY j.idJeu desc";

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
 * retourne un tableau avec toutes les catégories de jeu
 *
 * @return array
 */
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
/**
 * retourne un tableau avec tout les information d'un jeu
 *
 * @param [string] $nomJeu
 * @return array
 */
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
/**
 * retourne un tableau de jeux filter par multiple critères
 *
 * @param [string] $titre
 * @param [int] $idCategorie
 * @param [int] $annee
 * @param [int] $moyenne
 * @param [string] $utilisateur
 * @return array
 */
function rechercheJeu($titre, $idCategorie, $annee, $moyenne,$utilisateur)
{
    static $ps = null;

    $sql = "SELECT j.titre, j.appreciation, j.imageJeu FROM JEU j, UTILISATEUR u, CATEGORIE c WHERE j.public=true AND c.idCategorie=j.idCategorie AND u.idUtilisateur =j.idUtilisateur ";
    if ($titre != "") {
        $sql .= "AND titre LIKE :TITRE ";
    }
    if ($idCategorie != "") {
        $sql .= "AND j.idCategorie = :IDCATEGORIE ";
    }

    if ($moyenne != "") {
        $sql .= "AND j.appreciation >= :MOYENNE ";
    }
    if ($annee != "") {
        $sql .= "AND j.dateSorite >= :ANNEE ";
    }
    if ($utilisateur != "") {
        $sql .= "AND j.idUtilisateur = u.idUtilisateur AND u.pseudo = :UTILISATEUR";
    }

    // $sql = "SELECT j.titre,j.imageJeu,j.dateSorite ,c.categorie  FROM JEU j , CATEGORIE c ";
    // $sql .= "WHERE j.idCategorie =c.idCategorie ;";

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
    }
    $reponse = false;

    try {
        if ($titre != "") {
            $titre = "%" . $titre . "%";
            $ps->bindParam(":TITRE", $titre, PDO::PARAM_STR);
        }
        if ($idCategorie != "") {
            $ps->bindParam(":IDCATEGORIE", $idCategorie, PDO::PARAM_INT);
        }
        if ($annee != "") {
            $annee = $annee . "-01-01";
            $ps->bindParam(":ANNEE", $annee, PDO::PARAM_STR);
        }
        if ($moyenne != "") {
            
            $ps->bindParam(":MOYENNE", $moyenne, PDO::PARAM_INT);
        }
        if ($utilisateur != "") {
            $ps->bindParam(":UTILISATEUR", $utilisateur, PDO::PARAM_STR);
        }
        if ($ps->execute())
            $reponse = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $reponse;
}
/**
 * retourne un tableau avec tout les jeux créer par un utilisateur
 *
 * @param [string] $pseudo
 * @return array
 */
function listeJeuxUtilisateur($pseudo){
    static $ps = null;
    $sql = "SELECT j.titre,j.idJeu,j.dateSorite,j.imageJeu, j.public, c.categorie FROM JEU j , CATEGORIE c, UTILISATEUR u ";
    $sql .= "WHERE j.idCategorie =c.idCategorie ";
    $sql .= "AND j.idUtilisateur = u.idUtilisateur ";
    $sql .= "AND u.pseudo = :PSEUDO ";
    $sql .= "ORDER BY j.titre ASC";

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
/**
 * change le statut d'un jeu de privé à public
 *
 * @param [int] $idJeu
 * @return void
 */
function passerJeuPublic($idJeu){
    static $ps = null;
    $sql = "UPDATE JEU SET public = true ";
    $sql .= "WHERE JEU.idJeu = :IDJEU";

    if ($ps == null) {
        $ps = connexionBDD()->prepare($sql);
    }
    $reponse = false;

    try {
        $ps->bindParam(":IDJEU", $idJeu, PDO::PARAM_INT);

        $reponse = $ps->execute();
    } catch (PDOException $e) {
        echo ($e->getMessage());
    }
    return $reponse;
}
