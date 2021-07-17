<?php 

session_start();

$idsGroupes = $_POST['select_groupes'];
// $idsPromos = $_POST['select_promos'];
echo $nomPromo = $_POST['promo_nom'];
echo $dateCreation = $_POST['date_rentree'];

include "../../client-side/connexionBDD.php";


if (isset($_GET["action"]) && $_GET["action"]=="edit"){

    echo $idPromo = $_GET['id'];
    $idsGroupesBefore = $_SESSION['groupes_selected'];
    // echo $idsPromosBefore = $_SESSION['promos_selected'];

    $stmtNom = $dbh->prepare("UPDATE promo SET nomPromo = '$nomPromo', dateCreation = '$dateCreation' WHERE idPromo = '$idPromo' ");
    $donneesNom = $stmtNom->execute();

    for ($i=0; $i < count($idsGroupesBefore); $i++) { 
        $stmtDeleteGroupePromo = $dbh->prepare("UPDATE groupe SET idPromo=NULL WHERE idGroupe= '$idsGroupesBefore[$i]' ");
        $donneesDeleteGroupePromo = $stmtDeleteGroupePromo->execute();
    }

    for ($i=0; $i < count($idsGroupes); $i++) { 
        $stmtInsertGroupePromo = $dbh->prepare("UPDATE groupe SET idPromo = '$idPromo' WHERE idGroupe= '$idsGroupes[$i]' ");
        $donneesInsertGroupePromo = $stmtInsertGroupePromo->execute();
    }   

}
else {
    // echo $idsPromos;
    $stmtNom = $dbh->prepare("INSERT INTO promo (idPromo, nomPromo, dateCreation) VALUES ('', '$nomPromo', '$dateCreation') ");
    $donneesNom = $stmtNom->execute();

    $stmtIdPromo = $dbh->prepare("SELECT idPromo FROM promo ORDER BY idPromo desc LIMIT 1");
    $donneesIdPromo = $stmtIdPromo->execute();
    $donneesIdPromo = $stmtIdPromo->fetch();
    $idPromo = $donneesIdPromo['idPromo']; 


    for ($i=0; $i < count($idsGroupes); $i++) { 
        $stmtInsertGroupes = $dbh->prepare("UPDATE groupe SET idPromo = '$idPromo' WHERE idGroupe= '$idsGroupes[$i]' ");
        $donneesInsertGroupes = $stmtInsertGroupes->execute();
    }

    // for ($i=0; $i < count($idsPromos); $i++) { 
        // $stmtInsertPromos = $dbh->prepare("INSERT INTO groupe (idPromo, idGroupe) VALUES ('$idsPromos', '$idMatiere')");
        // $donneesInsertPromos = $stmtInsertPromos->execute();
    // }
   
}

$_SESSION['error_message'] = "";    
$_SESSION['done_message'] = "Les modifications ont bien été prises en compte.";

for ($i=0; $i < count($idsGroupes); $i++) { 
    if (isset($stringGroupes)){
        $stringGroupes =  $stringGroupes.'&idGroupe[]='.$idsGroupes[$i];
    }
    else {
        $stringGroupes = '&idGroupe[]='.$idsGroupes[$i];
    }
};


// header("Location: promos-create.php?action=edit&id=$idPromo&promo=$nomPromo$stringGroupes");