<?php
session_start();    

$idMatiere = $_SESSION['idMatiere'];
$signatureUser = $_SESSION["signatureUser"];
$uid = $_GET["uid"];
if (!isset($_SESSION['idProfAdmin'])){
    $idUser = $_SESSION["id"];
}
else {
    $idUser = $_SESSION["idProfAdmin"]; 
}
$_SESSION['dateDebut'] = $_POST["inputTimeDebut"];
$dateTimeDebut =  $_SESSION["dateBDD"]." ".$_SESSION['dateDebut'];
$_SESSION["heureArrivee"] = $dateTimeDebut;
$_SESSION['dateFin'] =$_POST["inputTimeFin"];
$dateTimeFin =  $_SESSION["dateBDD"]." ".$_SESSION['dateFin'];
$anneeScolaire = $_SESSION["anneeScolaire"];


if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

    include 'connexionBDD.php';

    $stmt = $dbh -> prepare("INSERT INTO cours (idCours, idGroupe, idMatiere, idUser, dateTimeDebut, dateTimeFin, anneeScolaire, isEnded) VALUES ('', '$uid', '$idMatiere', '$idUser', '$dateTimeDebut', '$dateTimeFin', '$anneeScolaire', '0');");

    $donnees = $stmt-> execute();  

    $stmtCours = $dbh -> prepare("SELECT idCours FROM cours ORDER BY idCours DESC LIMIT 1");
    $donneesCours = $stmtCours-> execute(); 
    while ($donneesCours =$stmtCours->fetch()) {
        $_SESSION["idCours"]= $donneesCours["idCours"];
       
    }
     
    header ("Location: liste.php?uid=$uid");

}

