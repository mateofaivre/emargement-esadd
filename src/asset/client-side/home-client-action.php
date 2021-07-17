<?php
session_start();
$signatureUser = $_SESSION["signatureUser"];
$idUser = $_SESSION['id'];
$typeCours = $_GET['typeCours'];

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

    include 'connexionBDD.php';

    $stmtCours = $dbh -> prepare("SELECT DISTINCT(cours.idCours), dateTimeDebut FROM coursuser, groupe, cours, groupeuser, user WHERE cours.idGroupe = groupe.idGroupe AND groupe.idGroupe = groupeuser.idGroupe AND groupeuser.idUser = user.idUser AND user.idUser = '$idUser' ORDER BY `cours`.`idCours` DESC LIMIT 1");

    $donneesCours = $stmtCours-> execute();  

    while ($donneesCours =$stmtCours->fetch()) {
        $idCours = $donneesCours["idCours"];
        $dateTimeDebut = $donneesCours["dateTimeDebut"];
    }
    $heureRetard = strtotime("+2 minutes", strtotime($dateTimeDebut)); // valeur retard à modifier
  
    $heureActuelle = strtotime(date('Y/m/d H:i:s'));

    if ($heureActuelle > $heureRetard){
        $dateTimeDebut= date("Y-m-d H:i:s", $heureActuelle);
    }   

    $stmtInsert = $dbh -> prepare("INSERT INTO coursuser (idCours, idUser, heureArrivee, typeCours) VALUES ('$idCours', '$idUser', '$dateTimeDebut', $typeCours)");

    try {
        $donneesInsert = $stmtInsert-> execute();
        header ("Location: home-client-connected.php");
     } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
           header ("Location: home-client-connected.php");
        } else {
            echo 'fuck';
        }
     }

   
}
else{
    header("Location: ../../../index.php"); 
}


?>