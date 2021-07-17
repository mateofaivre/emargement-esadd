<?php 

session_start();


$idsProfs = $_POST['select_profs'];
$idsPromos = $_POST['select_promos'];
$nomMatiere = $_POST['matiere_nom'];



include "../../client-side/connexionBDD.php";

if (isset($_GET["action"]) && $_GET["action"]=="edit"){

    $idMatiere = $_GET['id'];
    $idsProfsBefore = $_SESSION['profs_selected'];
    $idsPromosBefore = $_SESSION['promos_selected'];

    $stmtNom = $dbh->prepare("UPDATE matiere SET nomMatiere = '$nomMatiere' WHERE idMatiere = '$idMatiere' ");
    $donneesNom = $stmtNom->execute();

    for ($i=0; $i < count($idsProfsBefore); $i++) { 
        $stmtDeleteProfs = $dbh->prepare("DELETE FROM usermatiere WHERE idUser= '$idsProfsBefore[$i]' AND idMatiere = '$idMatiere' ");
        $donneesDeleteProfs = $stmtDeleteProfs->execute();
    }

    for ($i=0; $i < count($idsPromosBefore); $i++) { 
        $stmtDelete = $dbh->prepare("DELETE FROM matierepromo WHERE idPromo= '$idsPromosBefore[$i]' AND idMatiere = '$idMatiere' ");
        $donneesDelete = $stmtDelete->execute();
    }

    print_r($idsProfs);
    for ($i=0; $i < count($idsProfs); $i++) { 
       
        $stmtInsertProfs = $dbh->prepare("INSERT INTO usermatiere (idUser, idMatiere) VALUES ('$idsProfs[$i]', '$idMatiere')");
        $donneesInsertProfs = $stmtInsertProfs->execute();
    }

    for ($i=0; $i < count($idsPromos); $i++) { 
        $stmtInsertPromos = $dbh->prepare("INSERT INTO matierepromo (idPromo, idMatiere) VALUES ('$idsPromos[$i]', '$idMatiere')");
        $donneesInsertPromos = $stmtInsertPromos->execute();
    }

}
else {

    $stmtNom = $dbh->prepare("INSERT INTO matiere (idMatiere, nomMatiere) VALUES ('', '$nomMatiere') ");
    $donneesNom = $stmtNom->execute();

    $stmtIdMatiere = $dbh->prepare("SELECT idMatiere FROM matiere ORDER BY idMatiere desc LIMIT 1");
    $donneesIdMatiere = $stmtIdMatiere->execute();
    $donneesIdMatiere = $stmtIdMatiere->fetch();
    $idMatiere = $donneesIdMatiere['idMatiere']; 


    for ($i=0; $i < count($idsProfs); $i++) { 
        $stmtInsertProfs = $dbh->prepare("INSERT INTO usermatiere (idUser, idMatiere) VALUES ('$idsProfs[$i]', '$idMatiere')");
        $donneesInsertProfs = $stmtInsertProfs->execute();
    }

    for ($i=0; $i < count($idsPromos); $i++) { 
        $stmtInsertPromos = $dbh->prepare("INSERT INTO matierepromo (idPromo, idMatiere) VALUES ('$idsPromos[$i]', '$idMatiere')");
        $donneesInsertPromos = $stmtInsertPromos->execute();
    }

   
}

$_SESSION['error_message'] = "";    
$_SESSION['done_message'] = "Les modifications ont bien été prises en compte.";

for ($i=0; $i < count($idsPromos); $i++) { 
    if (isset($stringPromos)){
        $stringPromos =  $stringPromos.'&idPromo[]='.$idsPromos[$i];
    }
    else {
        $stringPromos = '&idPromo[]='.$idsPromos[$i];
    }
};

header("Location: matiere-create.php?action=edit&id=$idMatiere&matiere=$nomMatiere$stringPromos");