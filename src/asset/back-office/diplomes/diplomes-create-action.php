<?php 

session_start();

$nomDiplome = $_POST['diplome_nom'];
$dureeDiplome = $_POST['duree_diplome'];

include "../../client-side/connexionBDD.php";


if (isset($_GET["action"]) && $_GET["action"]=="edit"){

    $idDiplome = $_GET['id'];

    $stmtDiplome = $dbh->prepare("UPDATE diplome SET nomDiplome = '$nomDiplome', dureeDiplome =  '$dureeDiplome' WHERE idDiplome = '$idDiplome' ");
    $donneesDiplome = $stmtDiplome->execute();
}
else {
    $stmtInsert = $dbh->prepare("INSERT INTO diplome (idDiplome, nomDiplome, dureeDiplome) VALUES ('','$nomDiplome','$dureeDiplome') ");
    $donneesInsert = $stmtInsert->execute();
}

$_SESSION['error_message'] = "";    
$_SESSION['done_message'] = "Les modifications ont bien été prises en compte.";



header("Location: diplomes-create.php?action=edit&id=$idDiplome&diplome=$nomDiplome&dureeDiplome=$dureeDiplome");