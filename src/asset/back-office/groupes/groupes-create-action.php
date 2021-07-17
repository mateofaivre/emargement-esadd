<?php 

session_start();

$idsEleves = $_POST['select_eleves'];
$idsPromos = $_POST['select_promos'];
$nomGroupe = $_POST['groupe_nom'];

include "../../client-side/connexionBDD.php";

if (isset($_GET["action"]) && $_GET["action"]=="edit"){

    $idGroupe = $_GET['id'];
    // $idGroupe = $_POST
    ($idsElevesBefore = $_SESSION['eleves_selected']);
    echo $idsPromosBefore = $_SESSION['promos_selected'];

    $stmtNom = $dbh->prepare("UPDATE groupe SET nomGroupe = '$nomGroupe' WHERE idGroupe = '$idGroupe' ");
    $donneesNom = $stmtNom->execute();

    for ($i=0; $i < count($idsElevesBefore); $i++) { 
        $stmtDeleteEleves = $dbh->prepare("DELETE FROM groupeuser WHERE idUser= '$idsElevesBefore[$i]' AND idGroupe = '$idGroupe' ");
        $donneesDeleteEleves = $stmtDeleteEleves->execute();
    }
        if ($idsPromosBefore==''){
            $idsPromosBefore = 'NULL';
        }
        $stmtDelete = $dbh->prepare("UPDATE groupe SET idPromo= $idsPromosBefore WHERE idGroupe = '$idGroupe' ");
        $donneesDelete = $stmtDelete->execute();

    for ($i=0; $i < count($idsEleves); $i++) { 
        $stmtInsertEleves = $dbh->prepare("INSERT INTO groupeuser (idUser, idGroupe) VALUES ('$idsEleves[$i]', '$idGroupe')");
        $donneesInsertEleves = $stmtInsertEleves->execute();
    }   

        if ($idsPromos != $idsPromosBefore){
            echo $idsPromos;
            echo 'but';
            echo $idGroupe;
            $stmtInsertPromos = $dbh->prepare("UPDATE groupe SET idPromo = '$idsPromos' WHERE idGroupe = '$idGroupe'");
            $donneesInsertPromos = $stmtInsertPromos->execute();
        }
}
else {
    echo $idsPromos;
    $stmtNom = $dbh->prepare("INSERT INTO groupe (idGroupe, nomGroupe, idPromo) VALUES ('', '$nomGroupe', '$idsPromos') ");
    $donneesNom = $stmtNom->execute();

    $stmtIdGroupe = $dbh->prepare("SELECT idGroupe FROM groupe ORDER BY idGroupe desc LIMIT 1");
    $donneesIdGroupe = $stmtIdGroupe->execute();
    $donneesIdGroupe = $stmtIdGroupe->fetch();
    $idGroupe = $donneesIdGroupe['idGroupe']; 


    for ($i=0; $i < count($idsEleves); $i++) { 
        $stmtInsertEleves = $dbh->prepare("INSERT INTO groupeuser (idUser, idGroupe) VALUES ('$idsEleves[$i]', '$idGroupe')");
        $donneesInsertEleves = $stmtInsertEleves->execute();
    }
   
}

$_SESSION['error_message'] = "";    
$_SESSION['done_message'] = "Les modifications ont bien été prises en compte.";

header("Location: groupes-create.php?action=edit&id=$idGroupe&groupe=$nomGroupe&idPromo=$idsPromos");